

<?php $__env->startSection('content'); ?>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <div class="bg-white p-6 flex flex-col md:flex-row md:justify-between md:items-center shadow-sm border-b mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Event Management</h2>
            <button onclick="window.location.href='<?php echo e(route('events.create')); ?>'" class="mt-4 md:mt-0 bg-[#1B4B5A] text-white px-6 py-2 rounded-md font-semibold hover:bg-[#25697e] transition">Create Event</button>
        </div>
        <!-- Calendar and Events Section -->
        <div class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Calendar View -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <div id="calendar"></div>
            </div>
            <!-- Upcoming Events -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Upcoming Events</h3>
                <div class="space-y-4" id="upcoming-events"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '<?php echo e(route("events.json")); ?>',
            eventClick: function(info) {
                window.location.href = '/events/' + info.event.id;
            }
        });
        calendar.render();
        // Fetch and display upcoming events
        fetch('<?php echo e(route("events.upcoming")); ?>')
            .then(response => response.json())
            .then(events => {
                const upcomingEventsDiv = document.getElementById('upcoming-events');
                events.forEach(event => {
                    const eventEl = document.createElement('div');
                    eventEl.className = 'p-4 border rounded-lg hover:bg-gray-50 cursor-pointer';
                    eventEl.innerHTML = `
                        <h4 class="font-semibold">${event.title}</h4>
                        <p class="text-sm text-gray-600">${new Date(event.start_date).toLocaleDateString()}</p>
                        <p class="text-sm text-gray-500">${event.description}</p>
                    `;
                    eventEl.onclick = () => window.location.href = '/events/' + event.id;
                    upcomingEventsDiv.appendChild(eventEl);
                });
            });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/events/index.blade.php ENDPATH**/ ?>