<div class="align">

    <div class="grid">

        <form action="index.php?action=connexion" method="POST" class="form login">

            <div class="form__field">
                <label for="login__username"><i class='glyphicon glyphicon-user'></i><span class="hidden">Username</span></label>
                <input id="login__username" type="text" name="login" class="form__input" placeholder="Nom d'utilisateur" required>
            </div>

            <div class="form__field">
                <label for="login__password"><i class='glyphicon glyphicon-eye-close'></i><span class="hidden">Password</span></label>
                <input id="login__password" type="password" name="mdp" class="form__input" placeholder="Mot de passe" required>
            </div>
            <div class="form__field">
                <input type="submit" value="Se connecter">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                <label class="form-check-label" for="exampleCheck1" >Se souvenir de moi</label>
            </div>

        </form>

        <p class="text--center">Pas encore membre ? <a href="#" data-toggle="modal" data-target="#modalRegisterForm">S'inscrire</a> <i class='glyphicon glyphicon-pencil'></i></p>
    </div>



    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="index.php?action=creation" method="POST">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Inscription</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="md-form mb-5">
                            <i class="fa fa-user prefix grey-text"></i>
                            <input type="text" id="orangeForm-name" placeholder="Nom d'utilisateur" name="login" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="orangeForm-name"></label>
                        </div>
                        <div class="md-form mb-5">
                            <i class="fa fa-envelope prefix grey-text"></i>
                            <input type="email" id="orangeForm-email" placeholder="Votre email" name="email" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="orangeForm-email"></label>
                        </div>

                        <div class="md-form mb-4">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" id="orangeForm-pass2" placeholder="Mot de passe" name="mdp" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="orangeForm-pass"></label>
                        </div>
                        <div class="md-form mb-4">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" id="orangeForm-pass" placeholder="Mot de passe" name="mdp2" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="orangeForm-pass"></label>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-deep-orange">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
