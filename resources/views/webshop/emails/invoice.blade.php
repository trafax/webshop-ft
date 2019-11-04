@extends('layouts.email')

@section('content')
    <table  style="width: 100%  !important; margin-top: 10px;">
        <tr>
            <td valign="top" style="width: 100%  !important;">
                {!! $html !!}
            </td>
        </tr>
    </table>
@endsection
