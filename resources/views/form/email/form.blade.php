@extends('layouts.email')

@section('content')

    <table  style="width: 700px !important; margin-top: 10px;">
        <tr>
            <td valign="top" style="width: 100%  !important;">

                {!! $form->text_email !!}
                <br>

                <table  style="width: 700px !important; margin-top: 10px;">
                    @foreach ($request->all() as $field => $value)
                        @php
                            $value = is_array($value) ? implode(', ', $value) : $value;
                        @endphp
                        <tr>
                            <td><strong>{{ $field }}</strong></td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>

@endsection
