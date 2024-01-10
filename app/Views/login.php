<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="<?php echo base_url("assets/css/global.css")?>" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js" defer></script>
    <title>AMZMP - Login</title>
</head>
<body>
    <div class="loading" id="loading">
        <div class="text-center">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>
    <div class="container-sm text-align">
        <div class="row" style="display: flex;align-items: center;height: 100vh;">
            <div class="col">
                <div class="row">
                    <h2 id="typed"></h2>
                </div>
            </div>
            <div class="col">
                <form>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="nome@exemplo.com">
                    </div>

                    <div class="mb-3">
                        <label for="inputPassword5" class="form-label">Senha</label>
                        <input type="password" id="password" class="form-control" aria-describedby="passwordHelpBlock">
                        <div id="passwordHelpBlock" class="form-text">
                            Seus dados são estratégicamente protegidos e criptografados para que não haja problemas com invasões.
                        </div>
                    </div>

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-success" type="button" id="btnSend">Entrar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(()=>{
            var typed = new Typed('#typed', {
                strings: ['Bem-vindo ao Software AMZMP,', '<i>Yan Pablo Rodrigues</i><br> agradece sua presença!'],
                smartBackspace: true,
                typeSpeed: 50,
            });

            document.getElementById("btnSend").addEventListener("click",()=>{
                $(".loading").attr("style", "display: flex");
                let data = sendData();

                if(!data)
                {
                    alert("senha ou email incorreto!");
                }
                data.then((obj) => {
                    if(obj.statusCode == 200)
                    {
                        localStorage.setItem("token", obj.token);
                        window.location.href = "/clients";
                    }
                    else if(obj.statusCode == 400)
                    {
                        $(".loading").attr("style", "display: none");
                        Swal.fire({
                            title: "Incorreto",
                            text: "Verifique seu email e sua senha para continuar!",
                            icon: "error"
                        });
                    }
                    else if(obj.statusCode == 500)
                    {
                        $(".loading").attr("style", "display: none");
                        Swal.fire({
                            title: "Erro interno",
                            text: "Este é um aviso de erro nos servidores, o mesmo pode estar sendo ocasionado por conta de problemas com banco de dados.",
                            icon: "error"
                        });
                    }
                    
                }); 
                
            });

            


            async function sendData()
            {
                $(".loading").attr("style", "display: flex");
                const inputEmail = $("#email").val();
                const inputPassword = $("#password").val(); 
                let dados = {
                    "email": `${inputEmail}`,
                    "password": `${inputPassword}`
                };
                $("#email").val("");
                $("#password").val("");
                return await new Promise((resolve, reject)=>{
                    $.ajax({
                        method: "POST",
                        url: "/auth",
                        dataType:"JSON",
                        data: dados,
                        success: (resp) =>{
                            resolve(resp);
                        },
                        error: (err) =>{
                            reject(err);
                        }
                    });
                });
                $(".loading").attr("style", "display: none");
            }
        });
    </script>
</body>
</html>