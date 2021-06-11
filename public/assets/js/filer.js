const segment = document.querySelector('.segment')
const vendeur = document.querySelector('.vendeur')
const Statu = document.querySelector('.Statu')
const client = document.querySelector('.client')
const tableBody = document.querySelector('.tableBody')

const xhr = new XMLHttpRequest()

segment.addEventListener('input', getResult )
vendeur.addEventListener('input', getResult )
Statu.addEventListener('input', getResult )
client.addEventListener('input', getResult )

function getResult(event){
    xhr.open('post', `/admin/filter?seg=${segment.value}&vendeur=${vendeur.value}&state=${Statu.value}&client=${client.value}`, true)
    xhr.onreadystatechange = function (){
        if(xhr.status === 200 && xhr.readyState === 4){
            tableBody.innerHTML = '';
            var res = JSON.parse(xhr.response);

            res.forEach((el)=>{
                console.log(el)
                tableBody.innerHTML += `
                    <tr>
                        <td>${el.raison}</td>
                        <td>${el.nom}</td>
                        <td>${el.contact}</td>
                        <td>${el.consommation_elec} Mwh</td>
                        <td>${el.consommation_gaz} Mwh</td>
                        <td>${el.state}</td>
                        <td>${el.vendeur}</td>
                        <td>${el.segmentation}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/admin/edit-user/${el.id}.html">Client</a>
                                    <a class="dropdown-item" href="/admin/perimetre/client-${el.id}.htm">Périmètres</a>
                                    <a class="dropdown-item" href="/admin/historique-${el.id}.html">Historiques</a>
                                    <a class="dropdown-item" href="/admin/newOffreElec-${el.id}.html">Créer une opportunité éléctricité</a>
                                    <a class="dropdown-item" href="/admin/newOffreGaz-${el.id}.html">Créer une opportunité Gaz nature</a>
                                    <a class="dropdown-item" href="/admin/edit-budget?id=${el.id}&perim=elec">Budget en éléctrcicté</a>
                                    <a class="dropdown-item" href="/admin/edit-budget?id=${el.id}&perim=gaz">Budget en gaz naturel</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `
            })

        }else{

        }
    }
    xhr.send()
}