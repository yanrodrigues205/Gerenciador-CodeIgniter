$(document).ready(async ()=>{
    const tableSales = $("#tableSales").DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
        },
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }]
    });

    await update();
    async function update()
    {
        $(".loading").attr("style", "display: flex");
        
        await tableSales.clear().draw();

        let resp = await getAllSales();
        console.log(resp)
        for(var i = 0; i < resp.sales.length; i++)
        {
            ``
            let products = `<button class='btn btn-primary' title='Ver produtos da venda ID${resp.sales[i].id}' data-bs-toggle="modal" data-bs-target="#productsModel${resp.sales[i].id}"><i class="fa-solid fa-basket-shopping"></i></button>
                            <div class="modal fade" id="productsModel${resp.sales[i].id}" tabindex="-1" aria-labelledby="productsModel${resp.sales[i].id}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="productsModel${resp.sales[i].id}Label">Produtos da venda ID ${resp.sales[i].id}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body"> 
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Quantidade</th>
                                                        <th scope="col">Valor Und.</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                      
                           `;
            for(let y = 0; y < resp.sales[i].products.length; y++)
            {
                let data = resp.sales[i].products[y];
                let subtotal = data.value * data.amount;
                products += `<td>${data.id}</td><td>${data.name}</td><td>${data.amount}</td><td>R$ ${data.value}</td><td><strong style='color: gray'>R$ ${subtotal.toFixed(2)}</strong></td><tr>`;
            }

            products += `</tbody></table></div></div></div></div>`;
            

           
            tableSales.row.add([
                resp.sales[i].id,
                `<i class="fa-solid fa-address-card"></i>&nbsp;${resp.sales[i].client_id}`,
                resp.sales[i].delivery_state,
                resp.sales[i].delivery_city,
                resp.sales[i].delivery_streetname,
                resp.sales[i].payment,
                `<strong style='color: gray'>R$ ${resp.sales[i].total.toFixed(2)}</strong>`,
                `   ${products}
                    <a data-id="${resp.sales[i].id}" title="Alterar cliente ID ${resp.sales[i].id}" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateClientModal" id="btnEdit"><i class="fa-regular fa-rectangle-list" style="color: white"></i></a>
                    <a data-id="${resp.sales[i].id}" title="Excluir cliente ID ${resp.sales[i].id}" class="btn btn-danger" id="btnDelete"><i class="fa-solid fa-trash" style="color: white"></i></a>`
            ]).draw();
        }
        $(".loading").attr("style", "display: none");
    }

    async function getAllSales()
    {
        return await new Promise((resolve, reject) => {                                
            $.ajax({
                data: {},
                url: "/sales/getAllSales",
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
});