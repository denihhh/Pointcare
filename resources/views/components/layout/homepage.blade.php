@props([
    'upcomingAppointment' => null, 
    'todayCount' => 0, 
    'pendingCount' => 0, 
    'pastAppointments' => collect(), 
    'todayAppointments' => collect(),
    'patientCount' => 0,
    'doctorCount' => 0,
    'adminCount' => 0,
    'appointmentCount' => 0,
    'systemMetrics' => [],
    'recentUsers' => collect()
])

<x-animation>
    @if (auth()->user()->role === 'patient')
        <x-layout.homepage.patient
            :upcomingAppointment="$upcomingAppointment"
            :pastAppointments="$pastAppointments"
        />
    @elseif (auth()->user()->role === 'doctor')
        <x-layout.homepage.doctor
            :todayCount="$todayCount"
            :pendingCount="$pendingCount"
            :todayAppointments="$todayAppointments"
        />
    @elseif (auth()->user()->role === 'admin')
        <x-layout.homepage.admin
            :patientCount="$patientCount"
            :doctorCount="$doctorCount"
            :adminCount="$adminCount"
            :appointmentCount="$appointmentCount"
            :systemMetrics="$systemMetrics"
            :recentUsers="$recentUsers"
        />
    @endif
</x-animation>
