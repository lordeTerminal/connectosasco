<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connect Osasco</title>
    <link rel="stylesheet" href="style.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Roboto"
      rel="stylesheet"
      type="text/css"
    />
  </head>
  <body>
    <section class="forms-section">
      <div class="logo-indexPHP">
        <img 
          class="logotipo"
          src="./Logo Connect Osasco Branca.svg"
          alt="logotipo connect osasco"
        />
      </div>
      <div class="forms">
        <!-- Formulário de Login -->
        <div class="form-wrapper is-active f-indexPHP">
          <button type="button" class="switcher switcher-login">
            Entrar
            <span class="underline"></span>
          </button>
          <form class="form form-login" action="login.php" method="POST">
            <fieldset>
              <legend>Entre com seu e-mail institucional e senha</legend>
              <div class="input-block">
                <label for="login-email">E-mail Institucional</label>
                <input id="login-email" name="email" type="email" placeholder="Email" required />
              </div>
              <div class="input-block">
                <label for="login-senha">Senha</label>
                <input id="login-senha" name="password" type="password" placeholder="Senha" required />
              </div>
            </fieldset>
            <button type="submit" class="btn-entrar">Entrar</button>
          </form>
        </div>

        <!-- Formulário de Registro -->
        <div class="form-wrapper form-registro">
          <button type="button" class="switcher switcher-signup">
            Registrar
            <span class="underline"></span>
          </button>
          <form class="form form-signup" method="POST" action="register.php">
            <fieldset>
              <legend>Preencha os dados para registrar um novo usuário</legend>
              <div class="input-block">
                <label for="reg-username">Usuário</label>
                <input id="reg-username" type="text" name="username" placeholder="Nome de usuário" required />
              </div>
              <div class="input-block">
                <label for="reg-email">E-mail</label>
                <input id="reg-email" type="email" name="email" placeholder="Email" required />
              </div>
              <div class="input-block">
                <label for="reg-password">Senha</label>
                <input id="reg-password" type="password" name="password" placeholder="Senha" required />
              </div>
              <div class="input-block">
                <label for="reg-role">Função</label>
                <select id="reg-role" name="role">
                  <option value="Doctor">Profissional/Estudante</option>
                  <option value="Nurse">Corporativo/Empresa</option>
                  <option value="Admin">Recursos Humanos/Mediadores & Conectores</option>
                  <option value="Staff">Staff/Moderador</option>
                </select>
              </div>
            </fieldset>
            <button type="submit" class="btn-entrar">Registrar</button>
          </form>
        </div>
      </div>
    </section>

    <script src="script.js"></script>
  </body>
</html>

