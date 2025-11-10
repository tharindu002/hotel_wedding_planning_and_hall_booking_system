<section id="availability" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2>Check Hall Availability</h2>
            <p class="lead">View real-time availability for our wedding halls</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="availability-hall" class="form-label">Select Hall</label>
                                <select class="form-select" id="availability-hall">
                                    <option value="1">Grand Ballroom</option>
                                    <option value="2">Royal Garden</option>
                                    <option value="3">Ocean View Terrace</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="availability-month" class="form-label">Select Month</label>
                                <select class="form-select" id="availability-month">
                                    <option value="0">January 2025</option>
                                    <option value="1">February 2025</option>
                                    <option value="2">March 2025</option>
                                    <option value="3">April 2025</option>
                                    <option value="4" selected>May 2025</option>
                                    <option value="5">June 2025</option>
                                    <option value="6">July 2025</option>
                                    <option value="7">August 2025</option>
                                    <option value="8">September 2025</option>
                                    <option value="9">October 2025</option>
                                    <option value="10">November 2025</option>
                                    <option value="11">December 2025</option>
                                </select>
                            </div>
                        </div>

                        <div class="availability-calendar bg-white border rounded overflow-hidden">
                            <div class="row g-0 text-center bg-light">
                                <div class="col p-2 border">Sun</div>
                                <div class="col p-2 border">Mon</div>
                                <div class="col p-2 border">Tue</div>
                                <div class="col p-2 border">Wed</div>
                                <div class="col p-2 border">Thu</div>
                                <div class="col p-2 border">Fri</div>
                                <div class="col p-2 border">Sat</div>
                            </div>
                            <div id="calendar-grid">
                                <!-- Days will be generated here -->
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success me-2">Available</span>
                                <span class="badge bg-danger me-2">Booked</span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script>
function generateCalendar(month, year) {
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = '';

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    let dayCounter = 1;

    for (let i = 0; i < 6; i++) {
        const row = document.createElement('div');
        row.className = 'row g-0';

        for (let j = 0; j < 7; j++) {
            const col = document.createElement('div');
            col.className = 'col p-0 border calendar-day text-center d-flex align-items-center justify-content-center';

            if (i === 0 && j < firstDay) {
                col.innerHTML = ''; // blank
            } else if (dayCounter <= lastDate) {
                col.textContent = dayCounter;
                col.dataset.day = dayCounter;
                dayCounter++;
            }

            row.appendChild(col);
        }

        calendarGrid.appendChild(row);
    }

    loadAvailability();
}

function loadAvailability() {
    const hallId = document.getElementById('availability-hall').value;
    const month = parseInt(document.getElementById('availability-month').value);
    const year = 2025;

    fetch(`check_availability.php?hall_id=${hallId}&month=${month}&year=${year}`)
        .then(res => res.json())
        .then(bookedDays => {
            document.querySelectorAll('.calendar-day').forEach(day => {
                const d = parseInt(day.textContent.trim());
                if (!isNaN(d)) {
                    if (bookedDays.includes(d)) {
                        day.classList.add('booked');
                    } else {
                        day.classList.add('available');
                        day.addEventListener('click', function () {
                            document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                            this.classList.add('selected');
                        });
                    }
                }
            });
        });
}

// Initial generation
document.addEventListener('DOMContentLoaded', () => {
    const monthSelect = document.getElementById('availability-month');
    generateCalendar(parseInt(monthSelect.value), 2025);
});

// On change listeners
document.getElementById('availability-hall').addEventListener('change', () => {
    const month = parseInt(document.getElementById('availability-month').value);
    generateCalendar(month, 2025);
});

document.getElementById('availability-month').addEventListener('change', () => {
    const month = parseInt(document.getElementById('availability-month').value);
    generateCalendar(month, 2025);
});
</script>

<!-- Styles -->
<style>
.calendar-day {
    padding: 10px;
    margin: 1px;
    height: 50px;
    width: 100%;
    cursor: pointer;
    border-radius: 4px;
}

.calendar-day.booked {
    background-color: red;
    color: white;
    pointer-events: none;
}

.calendar-day.available {
    background-color: lightgreen;
}

.calendar-day.selected {
    border: 2px solid blue;
    background-color: #d0e7ff;
}
</style>
