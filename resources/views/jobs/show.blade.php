<x-layout>

    <x-slot:heading>
        Job Description
    </x-slot:heading>

    <h2 class="font-bold text-lg">{{ $job->title }}</h2>

    <p>
        This Job Pays {{ $job->salary }} per quarter.
    </p>

    @can('edit-job', $job)
        <p class="mt-6">
            <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
        </p>    
    @endcan

    {{-- with policy --}}
    @can('edit', $job)
        <p class="mt-6">
            <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
        </p>    
    @endcan
    

    
</x-layout>