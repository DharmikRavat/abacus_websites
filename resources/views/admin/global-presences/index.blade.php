@extends('admin.layout.app')

@section('content')

<div class="roles-header">
    <div>
        <h1>Global Presence</h1>
        <p>Manage countries and flags</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Country
    </button>
</div>

<div class="card">

    <div class="search-bar">

        <svg width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor"
             stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               placeholder="Search Countries..."
               oninput="filterCountries(this.value)">

        <span id="country-count"
              style="font-size:12px;color:var(--faint)">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Flag</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="countryBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <p>No Countries Found</p>
            <span>Create your first country</span>

        </div>

<div id="pagination" class="pagination"></div>
    </div>

</div>

{{-- CREATE / EDIT MODAL --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">Add Country</h2>

            <button class="btn-icon"
                    onclick="closeFormModal()">
                ✕
            </button>

        </div>

        <div class="modal-body">

            <div class="form-group">

                <label class="form-label">
                    Country Name *
                </label>

                <input type="text"
                       id="countryName"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">
                    Flag Image
                </label>

                <input type="file"
                       id="countryFlag"
                       class="form-control"
                       accept="image/*">

            </div>

            <div id="imagePreview"></div>

            <div class="form-group">

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">
                            Active
                        </div>

                        <div class="toggle-row-sub">
                            Country visible on website
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="countryStatus"
                               checked>

                        <span class="toggle-slider"></span>

                    </label>

                </label>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">
                Cancel
            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveCountry()">

                <span class="btn-label">
                    Save Country
                </span>

            </button>

        </div>

    </div>

</div>

{{-- DELETE MODAL --}}
<div class="modal-backdrop"
     id="deleteModal"
     onclick="handleDeleteBackdropClick(event)">

    <div class="modal"
         style="max-width:370px">

        <div class="confirm-modal-body">

            <h3>Delete Country?</h3>

            <p>
                This action cannot be undone.
            </p>

        </div>

        <div class="modal-footer"
             style="justify-content:center">

            <button class="btn btn-ghost"
                    onclick="closeDeleteModal()">
                Cancel
            </button>

            <button class="btn btn-danger"
                    onclick="confirmDelete()">

                Delete

            </button>

        </div>

    </div>

</div>

<script>

let countries = @json($globalPresences);

let editingId = null;
let deletingId = null;

let currentPage = 1;
const perPage = 5;

const CSRF =
document.querySelector('meta[name="csrf-token"]').content;

function formatDate(date){

    return new Date(date).toLocaleDateString();
}

function renderPagination(totalPages){

    let html='';

    html+=`
        <button
            ${currentPage==1?'disabled':''}
            onclick="changePage(${currentPage-1})">
            Previous
        </button>
    `;

    for(let i=1;i<=totalPages;i++){

        html+=`
            <button
                class="${i==currentPage?'active':''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html+=`
        <button
            ${currentPage==totalPages?'disabled':''}
            onclick="changePage(${currentPage+1})">
            Next
        </button>
    `;

    document.getElementById('pagination').innerHTML=html;

}
function changePage(page){

    currentPage=page;

    const search=document
        .querySelector('.search-bar input')
        .value
        .toLowerCase();

    render(

        countries.filter(c=>

            c.country_name
             .toLowerCase()
             .includes(search)

        )

    );

}

function render(list){

    const tbody =
    document.getElementById('countryBody');

    const empty =
    document.getElementById('emptyState');

    document.getElementById('country-count')
        .textContent =
        list.length + ' Countries';

    if(!list.length){

        tbody.innerHTML='';

        empty.style.display='block';

        document.getElementById('pagination').innerHTML='';

        return;
    }

    empty.style.display='none';

    const totalPages=Math.ceil(list.length/perPage);

    if(currentPage>totalPages)
        currentPage=totalPages;

    const start=(currentPage-1)*perPage;

    const pageData=list.slice(start,start+perPage);

    tbody.innerHTML=pageData.map((country,index)=>`

        <tr>

   <td>${start+index+1}</td>

            <td>
                ${
                    country.country_flag_image
                    ?
                    `<img src="/uploads/global-presence/${country.country_flag_image}"
                          width="40"
                          height="25"
                          style="border-radius:4px">`
                    :
                    '-'
                }
            </td>

            <td>
                <strong>${country.country_name}</strong>
            </td>

            <td>

                <div class="toggle-wrap">

                    <label class="toggle">

                        <input
                            type="checkbox"
                            ${country.status ? 'checked' : ''}
                            onchange="toggleStatus(${country.id},this.checked)">

                        <span class="toggle-slider"></span>

                    </label>

                    <span class="toggle-label
                    ${country.status ? 'active' : 'inactive'}">

                        ${country.status ? 'Active' : 'Inactive'}

                    </span>

                </div>

            </td>

            <td>
                ${formatDate(country.created_at)}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    <button class="btn-icon"
                            onclick="openEditModal(${country.id})">
                        ✏️
                    </button>

                    <button class="btn-icon"
                            onclick="openDeleteModal(${country.id})">
                        🗑️
                    </button>

                </div>

            </td>

        </tr>

    `).join('');
        renderPagination(totalPages);
}

function filterCountries(q){

    currentPage=1;

    q=q.toLowerCase();

    render(

        countries.filter(c=>

            c.country_name
             .toLowerCase()
             .includes(q)

        )

    );

}

function openCreateModal(){

    editingId = null;

    document.getElementById('modalTitle')
        .innerText = 'Add Country';

    document.getElementById('countryName').value = '';
    document.getElementById('countryFlag').value = '';
    document.getElementById('countryStatus').checked = true;

    document.getElementById('imagePreview')
        .innerHTML = '';

    document.getElementById('formModal')
        .classList.add('open');
}

function openEditModal(id){

    const country =
    countries.find(c => c.id == id);

    if(!country) return;

    editingId = id;

    document.getElementById('modalTitle')
        .innerText = 'Edit Country';

    document.getElementById('countryName')
        .value = country.country_name;

    document.getElementById('countryStatus')
        .checked = country.status == 1;

    document.getElementById('imagePreview')
        .innerHTML =
        country.country_flag_image
        ?
        `<img src="/uploads/global-presence/${country.country_flag_image}"
              width="80">`
        :
        '';

    document.getElementById('formModal')
        .classList.add('open');
}

function closeFormModal(){

    document.getElementById('formModal')
        .classList.remove('open');
}

function handleBackdropClick(e){

    if(e.target.id === 'formModal'){
        closeFormModal();
    }
}

async function saveCountry(){

    const formData = new FormData();

    formData.append(
        'country_name',
        document.getElementById('countryName').value
    );

    formData.append(
        'status',
        document.getElementById('countryStatus').checked ? 1 : 0
    );

    const image =
    document.getElementById('countryFlag').files[0];

    if(image){
        formData.append(
            'country_flag_image',
            image
        );
    }

    let url = '/admin/global-presences';
    let method = 'POST';

    if(editingId){

        url =
        `/admin/global-presences/${editingId}`;

        formData.append('_method','PUT');
    }

    const res = await fetch(url,{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':CSRF,
            'Accept':'application/json'
        },
        body:formData
    });

    const data = await res.json();

    if(!res.ok){

        alert(data.message || 'Error');

        return;
    }

if(editingId){

    const index=countries.findIndex(c=>c.id==editingId);

    if(index>-1)
        countries[index]=data.global_presence;

}else{

    countries.unshift(data.global_presence);

    currentPage=1;
}

render(countries);

closeFormModal();
}

async function toggleStatus(id,checked){

    const country =
    countries.find(c => c.id === id);

    if(!country) return;

    const formData = new FormData();

    formData.append(
        '_method',
        'PUT'
    );

    formData.append(
        'country_name',
        country.country_name
    );

    formData.append(
        'status',
        checked ? 1 : 0
    );

    await fetch(`/admin/global-presences/${id}`,{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':CSRF,
            'Accept':'application/json'
        },
        body:formData
    });

    country.status = checked ? 1 : 0;

    render(countries);
}

function openDeleteModal(id){

    deletingId = id;

    document.getElementById('deleteModal')
        .classList.add('open');
}

function closeDeleteModal(){

    deletingId = null;

    document.getElementById('deleteModal')
        .classList.remove('open');
}

function handleDeleteBackdropClick(e){

    if(e.target.id === 'deleteModal'){
        closeDeleteModal();
    }
}

async function confirmDelete(){

    if(!deletingId) return;

    const res = await fetch(
        `/admin/global-presences/${deletingId}`,
        {
            method:'DELETE',
            headers:{
                'X-CSRF-TOKEN':CSRF,
                'Accept':'application/json'
            }
        }
    );

    if(res.ok){

     countries=countries.filter(
    c=>c.id!==deletingId
);

const totalPages=Math.ceil(countries.length/perPage);

if(currentPage>totalPages){

    currentPage=totalPages||1;

}

render(countries);

closeDeleteModal();
    }
}

document.addEventListener('keydown',e=>{

    if(e.key === 'Escape'){

        closeFormModal();

        closeDeleteModal();
    }
});

render(countries);

</script>

@endsection