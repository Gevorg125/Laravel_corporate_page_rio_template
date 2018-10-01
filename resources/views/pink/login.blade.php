@extends(env('THEME').'.layouts.site')

{{--@section('navigation')--}}
{{--{!! $navigation !!}--}}
{{--@endsection--}}
{{--@section('slider')--}}
{{--{!! $sliders !!}--}}
{{--@endsection--}}
@section('content')
    <!-- START CONTENT -->
    <div id="content-page" class="content group">
        <div class="hentry group">
            <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ url('/log_in') }}">
                {{ csrf_field() }}
                <div class="usermessagea"></div>
                <fieldset>
                    <ul>
                        <li class="text-field">
                            <label for="login">
                                <span class="label">Name</span>
                                <br />					<span class="sublabel">This is the name</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="login" id="login" class="required" value="" /></div>
                            @if($errors->has('login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                                @endif
                        </li>

                        <li class="text-field">
                            <label for="password">
                                <span class="label">Password</span>
                                <br />					<span class="sublabel">This is the password</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="password" name="password" class="required" value="" /></div>
                            @if($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </li>

                        <li class="submit-button">
                            <input type="submit" name="yit_sendmail" value="LogIn" class="sendmail alignright" />
                        </li>

                    </ul>
                </fieldset>
            </form>
            {{--<script type="text/javascript">--}}
                {{--var messages_form_126 = {--}}
                    {{--name: "Please, fill in your name",--}}
                    {{--email: "Please, insert a valid email address",--}}
                    {{--message: "Please, insert your message"--}}
                {{--};--}}
            {{--</script>--}}
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
    </div>
    <!-- END CONTENT -->
@endsection
{{--@section('bar')--}}
{{--{!! $rightBar !!}--}}
{{--@endsection--}}
{{--@section('footer')--}}
{{--{!! $footer !!}--}}
{{--@endsection--}}