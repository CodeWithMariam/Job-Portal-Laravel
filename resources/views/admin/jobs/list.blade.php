@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="cls">Home</a></li>
                        <li class="breadcrumb-item active">Jobs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">

             @include('admin.sidebar')

            </div>
            <div class="col-lg-9">

                @include('front.message')

                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                   @if($jobs->isNotEmpty())
                                      @foreach($jobs as $job)
                                        <tr class="active">
                                            <td>{{ $job->id }}</td>
                                         <td>
                                            <div class="job-name ">
                                                <p>{{ $job->title }}</p>
                                                <p class="fs-7">Applicants: {{ $job->applications->count() }}</p>
                                            </div>
                                         </td>
                                          <td>{{ $job->user->name }}</td>
                                          <td>
                                              @if($job->status == 1)
                                                <p class="text-success">Active</p>
                                              @else
                                                <p class="text-danger">Block</p>
                                              @endif

                                          </td>
                                          <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                          <td>
                                            <div class="action-dots">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('jobDetail', $job->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.jobs.edit', $job->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="deleteJob({{ $job->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                             <tr>
                                                <td colspan="5" class="text-center">
                                                    <div style="font-size: 24px; font-weight: 900; margin-top: 20px;">Jobs not found.</div>
                                                </td>
                                            </tr>
                                   @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                             {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
                 <div class="card border-0 shadow mb-4">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
   function deleteJob(id) {
    if(confirm('Are you sure you want to delete this Job?')){
        $.ajax({
            url: "{{ route('admin.jobs.destroy') }}",
            type: 'DELETE',
            data: { id: id},
            dataType: 'json',
            success: function(response){
                if(response.status) {
                    window.location.href='{{ route("admin.jobs") }}';
                } else {
                    alert(response.message || 'Failed to delete the job.');
                }
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseText); // Handle AJAX error
            }
        });
    }
}

</script>

@endsection
