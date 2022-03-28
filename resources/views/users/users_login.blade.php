<!DOCTYPE html>
<html lang="ka" class="js">
<head>
    <title>DevLion CMS V 1.0</title>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ url('/assets/css/dashlite.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
</head>
<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title text-center font-neue">ავტორიზაცია</h4>
                                        <div class="nk-block-des text-center font-helvetica-regular">
                                            <p>სისტემაში შესასვლელად გთხოვთ გამოიყენოთ თქვენი ტელეფონის ნომერი და პაროლი</p>
                                        </div>
                                    </div>
                                </div>
                                <form id="user_login_form">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="user_phone">ტელეფონის ნომერი</label>
                                        </div>
                                        <input type="text" name="user_phone" class="form-control form-control-lg" id="user_phone">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="user_password">პაროლის აღდგენა</label>
                                            <a class="link link-primary font-helvetica-regular link-sm" href="javascript:;">დაგავიწყდა პაროლი?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="user_password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="user_password" name="user_password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block font-neue" type="button" onclick="UserLogin()">ავტორიზაცია</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="nk-block-content text-center">
                                        <p class="text-soft">&copy; Crafted with ❤️ By <a href="#">Mito Chikhladze</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/assets/js/bundle.js') }}"></script>
    <script src="{{ url('/assets/js/scripts.js') }}"></script>
    <script src="{{ url('/assets/scripts/users_scripts.js') }}"></script>
</body>
</html>