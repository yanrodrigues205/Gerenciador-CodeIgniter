$(document).ready(async ()=>{
    const tableClients = $("#tableClients").DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }]
    });
    
    const inputPhone = $("#phone");
    const inputAddress = document.getElementById("address");
    
    const maskPhone = {
        mask: ['(99) 9999-9999', '(99) 99999-9999']
    };

    const maskAddress = {
        mask: ['99999-999'],
        keepStatic: true
    }

    Inputmask(maskPhone).mask(inputPhone);
    Inputmask(maskAddress).mask(inputAddress);
    
    

    tableClients.on( 'search.dt', async () => {
        await events();
    } );
    
    tableClients.on( 'page.dt', async () => {
        await events();
    } );
    
    

    
    document.querySelectorAll("#getaddress").forEach((element)=>{
        element.addEventListener("click", async()=>{
            let address;
            if($(element).attr("name") == "edit")
            {
                address = document.getElementById("addressEdit");
            }
            else
            {
                address = document.getElementById("address");
            }
            
            let addressCEP = address.value.replace(/-/g, "");

            
            const CEPnumber = /^[0-9]+$/;
            const CEPformat = /^[0-9]{8}$/;
            if(!CEPnumber.test(addressCEP) || !CEPformat.test(addressCEP))
            {
                Swal.fire({
                    title: "CEP",
                    text: "Este não é um CEP, verifique se possuí apenas oito números, sem espaços ou letras.",
                    icon: "error"
                });
                
                address.value = "";
                return;
            }

            const searchAdress = await fetch(`https://viacep.com.br/ws/${addressCEP}/json/`);


            const response = await searchAdress.json();
            if(typeof response.logradouro !== "undefined")
            {
                if(inputAddress.inputmask)
                    inputAddress.inputmask.remove();

                address.value = `${response.logradouro} - ${response.bairro} , ${response.localidade} - ${response.uf}.`;
            }
            else
            {
                Swal.fire({
                    title: "CEP",
                    text: "Endereço de CEP não encontrado.",
                    icon: "error"
                });
                address.value = "";
                return;
            }
                
            
        });
    })

    let readToken = await new Promise((resolve, reject)=>{
                        $.ajax({
                            url: "/auth/readToken",
                            method: "GET",
                            headers:{
                                "Authorization": localStorage.getItem("token")
                            },
                            success: (resp) => {
                                if(typeof resp.data != "undefined")
                                {
                                    $("#profile").empty().append(`Olá ${resp.data.data.name_user},`);
                                }
                                resolve(resp)
                            },
                            error: (err) => {
                                reject(err)
                            }
                        });
                    });
    await updateTable();
    
    
    document.getElementById("clientForm").addEventListener("submit", function(event){
        event.preventDefault();
        Add();
    });
    
    document.getElementById("clientEditForm").addEventListener("submit", function(event){
        event.preventDefault();
        Edit();
    });
      
    function events()
    {
        
        document.querySelectorAll("#btnDelete").forEach((element)=>{
            element.addEventListener("click", async ()=>{
                let id = $(element).attr("data-id");
                console.log("btnDelete ID -> "+id);
                Swal.fire({
                    title: "Deletar cliente",
                    text: `Você deseja mesmo deletar o cliente ID ${id}`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não"
                  }).then(async (result) => {
                    if (result.isConfirmed) {

                        $(".loading").attr("style", "display: flex");
                        let resp = await new Promise((resolve, reject) => {
                            $.ajax({
                                url: `/clients/delete`,
                                method: "post",
                                dataType: "json",
                                data: {
                                    id
                                },
                                headers:
                                {
                                    "Authorization": localStorage.getItem("token")
                                },
                                success: (resp) => {
                                    console.log(resp);
                                    resolve(resp)
                                },
                                error: (err) => {
                                    reject(err)
                                }
                            });
                        
                        });
                        $("#idEdit").val("");
                        $("#emailEdit").val("");
                        $("#nameEdit").val("");
                        $("#addressEdit").val("");
                        $("#phoneEdit").val("");
                        await updateTable();
                        $(".loading").attr("style", "display: none");
                      Swal.fire({
                        title: "Sucesso!",
                        text: `Cliente ID ${id} deletado com sucesso!`,
                        icon: "success"
                      });

                    }
                  });
                
            });
        });


            document.querySelectorAll("#btnEdit").forEach((element)=>{
            element.addEventListener("click", async ()=>{
                let id = $(element).attr("data-id");
                $(".loading").attr("style", "display: flex");
                let resp = await new Promise((resolve, reject) => {
                    $.ajax({
                        url: `/clients/getbyid/${id}`,
                        method: "GET",
                        headers:
                        {
                            "Authorization": localStorage.getItem("token")
                        },
                        success: (resp) => {
                            resolve(resp)
                        },
                        error: (err) => {
                            reject(err)
                        }
                    });
                });
                $("#idEdit").val(id);
                $("#emailEdit").val(resp.client.email);
                $("#nameEdit").val(resp.client.name);
                $("#addressEdit").val(resp.client.address);
                $("#phoneEdit").val(resp.client.phone);
                $(".loading").attr("style", "display: none");
            });
        })
    }

   

   

    async function Edit()
    {
        let id = $("#idEdit").val();
        let name = $("#nameEdit").val();
        let address = $("#addressEdit").val();
        let email = $("#emailEdit").val();
        let phone = $("#phoneEdit").val();
        $(".loading").attr("style", "display: flex");
        try
        {
            let resp1 = await new Promise((resolve, reject) => {
                $.ajax({
                    url: "/clients/edit",
                    method: "post",
                    dataType: "json",
                    data: {
                        id:id,
                        name:name,
                        email:email,
                        phone:phone,
                        address: address
                    },
                    headers:
                    {
                        "Authorization": localStorage.getItem("token")
                    },
                    success: (resp) => {
                        resolve(resp)
                    },
                    error: (err) => {
                        reject(err)
                    }
                })
            });
        }
        catch(err)
        {
            console.log(err);
        }
        $(".loading").attr("style", "display: none");
        $("#idEdit").val("");
        $("#emailEdit").val("");
        $("#nameEdit").val("");
        $("#addressEdit").val("");
        $("#phoneEdit").val("");
        Swal.fire({
                    title: "Cliente",
                    text: `Editado com sucesso cliente de ID ${id}, ${name}`,
                    icon: "success"
        });
        await updateTable();
        
    }
    
    
    
    async function Add()
    {
        let name = $("#name").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let address = $("#address").val();

        if(!name || !email || !phone || !address)
        {
            Swal.fire({
                title: "Clientes",
                text: "Preencha todos os campos para concluir o envio!",
                icon: "error"
            });
            return;
        }

       
        
        $(".loading").attr("style", "display: flex");
        await new Promise((resolve, reject) => {
            $.ajax({
                data: {
                    name,
                    email,
                    phone,
                    address
                },
                url: "/clients/add",
                type: "POST",
                dataType: "json",
                headers:{
                    "Authorization": localStorage.getItem("token")
                },
                success: (resp) => {
                    resolve(resp)
                },
                error: (err) => {
                    reject(err)
                }
            });
        });
        await updateTable();
        $(".loading").attr("style", "display: none");
        Swal.fire({
            title: "Clientes",
            text: "Registro adicionado com sucesso!",
            icon: "success"
        });
        Inputmask(maskAddress).mask(inputAddress);
        $("#name").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#address").val("");
    }

    async function getAllUsers()
    {
        
        return await new Promise((resolve, reject) => {    
                                
                                $.ajax({
                                    data: {},
                                    url: "/clients/getall",
                                    type: "GET",
                                    dataType: "json",
                                    headers:{
                                        "Authorization": localStorage.getItem("token")
                                    },
                                    success: (resp) => {
                                        resolve(resp);
                                    },
                                    error: (err) => {
                                        reject(err);
                                    }
                                });
                        });
    } 

    async function updateTable()
    {
        $(".loading").attr("style", "display: flex");
        
        await tableClients.clear().draw();

        let resp = await getAllUsers();
        for(var i = 0; i < resp.data_clients.length; i++)
        {
            tableClients.row.add([
                resp.data_clients[i].id,
                resp.data_clients[i].name,
                resp.data_clients[i].email,
                resp.data_clients[i].phone,
                resp.data_clients[i].address,
                `<a data-id="${resp.data_clients[i].id}" title="Alterar cliente ID ${resp.data_clients[i].id}" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateClientModal" id="btnEdit"><i class="fa-regular fa-rectangle-list" style="color: white"></i></a>
                    <a data-id="${resp.data_clients[i].id}" title="Excluir cliente ID ${resp.data_clients[i].id}" class="btn btn-danger" id="btnDelete"><i class="fa-solid fa-trash" style="color: white"></i></a>`
            ]).draw();
        }


        await AllPhones();
        await events();
        $(".loading").attr("style", "display: none");
    }


    async function AllPhones()
    {
        
        let region = await new Promise((resolve, reject) => {    
                                
                                $.ajax({
                                    data: {},
                                    url: "/clients/phoneStatesPercent",
                                    type: "GET",
                                    dataType: "json",
                                    headers:{
                                        "Authorization": localStorage.getItem("token")
                                    },
                                    success: (response) => {
                                        resolve(response);
                                    },
                                    error: (err) => {
                                        reject(err);
                                    }
                        });
                    });

        console.log(region);
        
        $("#chartRegions").empty();
        $("#chartNewsClients").empty();

        var chartRegions = new CanvasJS.Chart("chartRegions", {
            exportEnabled: true,
            animationEnabled: false,
            width: 450,
            height: 280,
            legend:{
                cursor: "pointer"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{y}%</strong>",
                indexLabel: "{name} - {y}%",
                dataPoints: [
                    { y: region.sudeste, name: "Sudeste", exploded: true },
                    { y: region.sul, name: "Sul" },
                    { y: region.centro_oeste, name: "Centro Oeste" },
                    { y: region.norte, name: "Norte" },
                    { y: region.nordeste, name: "Nordeste" }
                ]
            }]
        });

        let newsClients = await new Promise((resolve, reject) => {    
                                
                        $.ajax({
                            data: {},
                            url: "/clients/getNewsClients",
                            type: "GET",
                            dataType: "json",
                            headers:{
                                "Authorization": localStorage.getItem("token")
                            },
                            success: (response) => {
                                resolve(response);
                            },
                            error: (err) => {
                                reject(err);
                            }
                });
            });
            console.log(newsClients);
        var chartNewsCLients = new CanvasJS.Chart("chartNewsClients", {
            animationEnabled: false,
            exportEnabled: true,
            width: 450,
            height: 280,
            axisX: {
                title: "Tempo"
            },
            axisY: {
                title: "Clientes",
            },
            data: [{
                type: "line",
                yValueFormatString: "",
                dataPoints: [
                    {X: 15, y: newsClients.min15, label: "15 minutos"},
                    {X: 30, y: newsClients.min30, label: "30 minutos"},
                    {X: 45, y: newsClients.min45, label: "45 minutos"},
                    {X: 60, y: newsClients.one_hr, label: "uma hora"},
                    {X: 120, y: newsClients.two_hrs, label: "duas horas"},
                ]
            }]
            });
        chartRegions.render();
        
        chartNewsCLients.render();
        $(".canvasjs-chart-canvas")[0].style.position = "unset";
        $(".canvasjs-chart-canvas")[0].style.display = "flex";
        $(".canvasjs-chart-canvas")[3].style.position = "unset";
        $(".canvasjs-chart-canvas")[3].style.display = "flex";
        $(".canvasjs-chart-credit").remove()

    } 
});