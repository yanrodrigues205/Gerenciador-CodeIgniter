<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"> 
    <link href="<?php echo base_url("assets/css/global.css")?>" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous" ></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js" integrity="sha512-FJ2OYvUIXUqCcPf1stu+oTBlhn54W0UisZB/TNrZaVMHHhYvLBV9jMbvJYtvDe5x/WVaoXZ6KB+Uqe5hT2vlyA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <header>
            <div class="container text-center" style="height: 120px; display: grid; align-items: center;">
                <div class="row">
                    <div class="col">
                        <h2>Clientes <i class="fa-solid fa-address-card"></i></h2>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col">
                        <div><i class="fa-solid fa-user" style="font-size: 18px; color: gray;"></i>&nbsp;<span id="profile"></span></div>
                    </div>
                </div>
            </div>
    </header><br/>

    <main>
        <div class="loading" id="loading">
            <div class="text-center">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only"></span>
            </div>
            </div>
        </div>



          

        <div class="container-md">
            <button type="button" title="Adicionar cliente" class="btn btn-success" id="btnAdd" data-bs-toggle="modal" data-bs-target="#clientModal">
                <i class="fa-solid fa-plus"></i>
            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#graphicModel">
                <i class="fa-solid fa-chart-simple"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="graphicModel" tabindex="-1" aria-labelledby="graphicModelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="graphicModelLabel">Análises</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="align-items: center;display: flex;flex-direction: column;">
                        <strong>Telefone dos clientes associados as regiões do Brasil</strong>
                        <div id="chartRegions"></div>
                    </div>
                    <div style="align-items: center;display: flex;flex-direction: column;">
                        <strong>Quantidade de novos clientes</strong>
                        <div id="chartNewsClients"></div>
                    </div>
                </div>
                
                </div>
            </div>
            </div>

            <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="clientModalLabel">Novo Cliente</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="clientForm">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="name" placeholder="Exemplo da Silva" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="nome@exemplo.com" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="(00) 00000-0000" required>
                                </div>

                                <div class="mb-1">
                                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                                    <div class="column">
                                        <button type="button" class="btn" title="Pesquisar" id="getaddress"> <i class="fa-solid fa-magnifying-glass"></i> Procurar CEP</button>
                                        <textarea type="text" class="form-control address" id="address" required></textarea>
                                        <sub>Digite o CEP e clique no botão para procurar o endereço automático (sem traços, espaços ou letras).</sub>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="submit" class="btn btn-primary" title="Salvar cliente" data-bs-dismiss="modal"><i class="fa-solid fa-floppy-disk"></i></button>
                                </div>

                                
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>


            <div class="modal fade" id="updateClientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="clientModalLabel">Alterar Cliente</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <form method="post" id="clientEditForm">
                                <input type="hidden" class="form-control" id="idEdit">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nameEdit" placeholder="Exemplo da Silva" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="emailEdit" placeholder="nome@exemplo.com" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="phoneEdit" placeholder="(00) 00000-0000" required>
                                </div>

                                <div class="mb-1">
                                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                                    <div class="column">
                                        <button type="button" class="btn" title="Pesquisar" id="getaddress" name="edit"> <i class="fa-solid fa-magnifying-glass"></i> Procurar CEP</button>
                                        <textarea type="text" class="form-control address" id="addressEdit" required></textarea>
                                        <sub>Digite o CEP e clique no botão para procurar o endereço automático (sem traços, espaços ou letras).</sub>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="submit" class="btn btn-primary" title="Salvar cliente" data-bs-dismiss="modal"><i class="fa-solid fa-floppy-disk"></i></button>
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="container-md">
            <div class="row">
                <table class="table" id="tableClients">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Operações</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTable">
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script type="text/javascript" src="<?php echo base_url("assets/js/clients.js"); ?>"></script>
</body>
</html>