@extends('layouts.app')

@section('content')
<div class="container">
<div style="margin-left: 76%;margin-bottom: 1%;">
<a <button type="button"  href="{{ route('home')}}"   class="btn btn-primary">Back</button> </a>
</div>
    <div class="row justify-content-center">
        <div class="col-md-8">
 
            <div class="card">
                <div class="card-header">{{ __('EMIDetails') }}</div>

                <div class="card-body" class="col-md-9" style="overflow-x: auto">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table" class="table table-bordered" style="width:auto">
                        <thead>
                            <tr>
                                <th scope="col">ClientID</th>
                                 @foreach ($months as $k=> $metadata)

                                <th scope="col">{{ preg_replace('/[^a-zA-Z0-9_.]/', '',  $metadata) }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                              foreach ($EmiDetail as $k=> $emi){ ?>
                            <tr>
                                <td scope="col"> <?php echo $emi['clientid']; ?> </td>
                                <?php foreach($months as $p=>$val){
                                     $coloumdata = preg_replace('/[^a-zA-Z0-9_.]/', '',  $val);
                                    ?>
                                    <td > <?php echo $emi[$coloumdata]; ?> </td>
                                    <?php  }?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
