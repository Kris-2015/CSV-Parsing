@extends('layout.app')

@section('title', 'Display Information')

@section('css')
    <link rel="stylesheet" href="{{url('css/main-page.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-11">
            <h3>Employee table</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th >Empid</th>
                        <th >First Name</th>
                        <th >Last Name</th>
                        <th >Skill 1</th>
                        <th >Skill 2</th>
                        <th >Skill 3</th>
                        <th >Skill 4</th>
                        <th >Skill 5</th>
                        <th >Stack Id</th>
                        <th >Stack NickName</th>
                        <th >Created By</th>
                        <th >Updated By</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Generate the rows of employee details -->
                @foreach ($employee as $index => $data)
                    <tr>
                        <td>{{ $data['emp_id'] }}</td>
                        <td>{{ $data['first_name'] }}</td>
                        <td>{{ $data['last_name'] }}</td>
                        <!-- Generate the skills dynamically -->
                        @php
                            $skills = explode(',' , $data['skills']);

                            // Maximun five skills are expected
                            for($i=0; $i<5; $i++)
                            {
                                echo "<td>";

                                // If skills index has no value, set empty column
                                echo isset($skills[$i]) ? $skills[$i] : '';
                                echo "</td>";
                            }
                        @endphp
                        <td>{{ $data['stack_id'] }}</td>
                        <td>{{ $data['stack_nickname'] }}</td>
                        <td>{{ $data['created_by'] }}</td>
                        <td>{{ $data['updated_by'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection