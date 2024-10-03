@extends('layouts.app6')

@section('title', 'Actions Performed ')
@section('page_title', 'Actions Performed')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection

@section('main_content')

<div class="col-12">
    <div class="form-group">
        <div role="group" class="btn-group">
            <ul class="nav">
                <li>
                    <a href="{{ route('equipment.actions.actions_performed') }}" class="btn btn-default btn-success">Add Quantity</a>
                </li>
                <li>
                    <a href="{{ route('equipment.actions.actions_performed_give') }}" class="btn btn-success">Give Out</a>
                </li>
                <li>
                    <a href="{{ route('equipment.actions.actions_performed_recommend') }}" class="btn btn-default btn-success">Recommend for Repair</a>
                </li>
                <li>
                    <a href="{{ route('equipment.actions.actions_performed_dispose') }}" class="btn btn-default btn-success">Dispose</a>
                </li>

            </ul>
        </div>
    </div>
</div>

    <div class="col-sm-12">
        <div class="card card-success card-outline">           
            <div class="card-body table-responsive">
                <table id="example3" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr> 
                            <th>ID</th>                          
                            <th>Date </th>
                            <th>Equipment </th>
                            <th>Given Out By</th>
                            <th>Taken By</th>
                            <th>Quantity Taken</th>
                            <th>Reverse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($actions->isEmpty())
                            @foreach ($actions as $action)                          
                            <tr class="text-nowrap @if ($action->is_reversed or $action->reverses) text-muted @endif">
                                <th>{{ $action->id }}</th>
                                    <td>{{ $action->date }}</td>
                                    <td>{{ $action->equipment->name }}</td>
                                    <td>{{ $action->user->name }}</td>
                                    <td>{{ $action->person->name }}</td>
                                    <td>{{ $action->quantity }}</td>
                                    <td>
                                        @if ($action->reverses)
                                        Reverses #{{ $action->reverses }}
                                        @elseif($action->is_reversed)
                                        Reversed by #{{ $action->reversed_by }} : {{ $action->reversal_reason }}                                           
                                        @else
                                            <button name="submit" type="submit" class="btn btn-sm btn-danger p-1"
                                                data-toggle="modal"
                                                data-target="#modal-lg-{{ $action->id }}">Reverse</button>
                                        @endif
                                    </td>

                                    <!-- Modal -->
                                <div class="modal fade" id="modal-lg-{{ $action->id }}">
                                    <div class="modal-dialog modal-lg">
                                            <form method="post" action="{{ route('give.reverse') }}">
                                       
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">action Reversal</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="bg-danger"> Are you sure you want to reverse this
                                                            action ? <br>
                                                            Note that this cannot be undone!</p>
                                                        <p>
                                                            <b>Action Date: </b> {{ $action->date }} <br>                                                           
                                                            <b>Action type: </b> {{ $action->type }} <br>
                                                            <b>Quantity: </b> {{ $action->quantity }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="reversal_reason">Reason for Reversal? *</label>
                                                            <textarea id="reversal_reason" name="reversal_reason" class="form-control" rows="2"
                                                                placeholder="Enter Reason for the action reversal" value="{{ old('reversal_reason') }}" required></textarea>
                                                            @error('reversal_reason')
                                                                <div class="text-sm text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="date">Action Date *</label>
                                                            <div class="input-group date" id="date-{{ $action->id }}"
                                                                data-target-input="nearest">
                                                                <div class="input-group-prepend"
                                                                    data-target="#reservationdate-{{ $action->id }}"
                                                                    data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i
                                                                            class="fa fa-calendar"></i></div>
                                                                </div>
                                                                <input id="date" name="date" type="text"
                                                                    class="form-control datetimepicker-input datepicker"
                                                                    data-target="#reservationdate-{{ $action->id }}"
                                                                    value="{{ $action->date }}" placeholder="YYYY-MM-DD" required>
                                                            </div>
                                                            <input type="text" name="action_id"
                                                                value="{{ $action->id }}" required hidden>  
                                                                <input type="text" name="equipment_id"
                                                                value="{{ $action->equipment->id }}" required hidden>                                                           
                                                            <input type="text" name="user_id"
                                                                value="{{ $user->id }}" required hidden>
                                                            @error('date')
                                                                <div class="text-sm text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer ">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Reverse
                                                    Transaction</button>
                                            </div>
                                        </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No equipment Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
