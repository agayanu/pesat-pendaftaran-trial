<link rel="stylesheet" href="{{ asset('datetimepicker/css/bootstrap-datetimepicker.css') }}">
<style>
@font-face{
    font-family:'Glyphicons Halflings';
    src:url({{url('fonts/glyphicons-halflings-regular.woff')}}) format('woff'),url({{url('fonts/glyphicons-halflings-regular.ttf')}}) format('truetype')
}
.glyphicon{
    position:relative;
    top:1px;
    display:inline-block;
    font-family:'Glyphicons Halflings';
    font-style:normal;
    font-weight:400;
    line-height:1;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale
}
.glyphicon-time:before {content:"\e023"}
.glyphicon-chevron-left:before{content:"\e079"}
.glyphicon-chevron-right:before{content:"\e080"}
.glyphicon-calendar:before {content: "\e109"}
.glyphicon-chevron-up:before {content: "\e113"}
.glyphicon-chevron-down:before {content: "\e114"}
.collapse.in {
    display: block;
    visibility: visible
}
.table-condensed>thead>tr>th,
.table-condensed>tbody>tr>th,
.table-condensed>tfoot>tr>th,
.table-condensed>thead>tr>td,
.table-condensed>tbody>tr>td,
.table-condensed>tfoot>tr>td {
    padding: 5px
}
.rqd {
    font-weight: bold;
    color: red;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #768192 !important;
}
.select2-container .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 12px !important;
    padding-right: 12px !important;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #d8dbe0 !important;
}
</style>
<script src="{{ asset('jquery/2.1.1.min.js') }}"></script>
<script src="{{ asset('jquery/moment-with-locales-2.9.0.js') }}"></script>
<script src="{{ asset('datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>