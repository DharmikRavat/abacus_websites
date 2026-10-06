@extends('admin.layout.app')

@section('content')

{{-- PAGE HEADER --}}
<div class="roles-header">
    <div>
        <h1>Products</h1>
        <p>Manage products</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Product
    </button>
</div>


{{-- TABLE CARD --}}
<div class="card">

    <div class="search-bar">

        <svg width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search products…"
               oninput="filterProducts(this.value)">

        <span id="product-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>


    <div style="overflow-x:auto">

        <table class="roles-table">

          <thead>
    <tr>
        <th style="width:40px">#</th>
        <th style="width:70px">Image</th>
        <th>Item Name</th>
        <th>Brand</th>
        <th>Type</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Qty</th>
        <th>Status</th>
        <th style="width:120px">Created</th>
        <th style="width:100px;text-align:right">Actions</th>
    </tr>
</thead>
            <tbody id="productBody"></tbody>

        </table>


        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <svg width="40" height="40" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 1 1 5.82 1
                         c0 2-3 3-3 3"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>

            <p>No products found</p>
            <span>Try a different search or create a new product</span>

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

            <h2 id="modalTitle">New Product</h2>

            <button class="btn-icon" onclick="closeFormModal()">
                <svg width="15" height="15" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>

        </div>


        <div class="modal-body">

        {{-- Item Image --}}
<div class="form-group">

    <label class="form-label">
        Item Image
    </label>

    <input type="file"
           id="itemImage"
           class="form-control"
           accept="image/jpeg,image/png,image/jpg,image/webp"
           onchange="previewItemImage(this)">

    <div id="imagePreview"
         style="margin-top:10px;display:none;">

        <img id="previewImage"
             src=""
             alt="Product Preview"
             style="
                width:100px;
                height:100px;
                object-fit:cover;
                border-radius:8px;
                border:1px solid #ddd;
             ">

    </div>

</div>

            {{-- Item Name --}}
            <div class="form-group">

                <label class="form-label">
                    Item Name *
                </label>

                <input type="text"
                       id="itemName"
                       class="form-control"
                       placeholder="Enter item name">

            </div>


            {{-- Brand --}}
            <div class="form-group">

                <label class="form-label">
                    Item Brand
                </label>

                <input type="text"
                       id="itemBrand"
                       class="form-control"
                       placeholder="Enter item brand">

            </div>


            {{-- Type --}}
           <div class="form-group">

    <label class="form-label">
        Item Type
    </label>

    <select id="itemType" class="form-control">

        <option value="">Select item type</option>
        <option value="Books">Books</option>
        <option value="Cubes">Cubes</option>
        <option value="Tools">Tools</option>
        <option value="Other">Other</option>

    </select>

</div>

            {{-- Description --}}
            <div class="form-group">

                <label class="form-label">
                    Description
                </label>

                <textarea id="itemDescription"
                          class="form-control"
                          rows="4"
                          placeholder="Enter item description"></textarea>

            </div>


            {{-- Price + Discount --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">

                <div class="form-group">

                    <label class="form-label">
                        Item Price *
                    </label>

                    <input type="number"
                           id="itemPrice"
                           class="form-control"
                           placeholder="0.00"
                           min="0"
                           step="0.01">

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Discount
                    </label>

                    <input type="number"
                           id="discountOnItem"
                           class="form-control"
                           placeholder="0.00"
                           min="0"
                           step="0.01">

                </div>

            </div>


            {{-- Quantity --}}
            <div class="form-group">

                <label class="form-label">
                    Quantity *
                </label>

                <input type="number"
                       id="itemQty"
                       class="form-control"
                       placeholder="Enter quantity"
                       min="0"
                       step="1">

            </div>


            {{-- Status --}}
            <div class="form-group">

                <label class="form-label">
                    Status
                </label>

                <label class="toggle-row" for="productActive">

                    <div>

                        <div class="toggle-row-label">
                            Active
                        </div>

                        <div class="toggle-row-sub">
                            Product visible to users
                        </div>

                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="productActive"
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
                    onclick="saveProduct()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Product
                </span>

            </button>

        </div>

    </div>
</div>


{{-- DELETE MODAL --}}
<div class="modal-backdrop"
     id="deleteModal"
     onclick="handleDeleteBackdropClick(event)">

    <div class="modal" style="max-width:370px">

        <div class="confirm-modal-body">

            <div class="confirm-icon">

                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">

                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>

                </svg>

            </div>

            <h3>Delete Product?</h3>

            <p>
                Are you sure you want to delete this product?
                <br>
                This action cannot be undone.
            </p>

        </div>


        <div class="modal-footer"
             style="justify-content:center;gap:10px">

            <button class="btn btn-ghost"
                    onclick="closeDeleteModal()">
                Cancel
            </button>

            <button class="btn btn-danger"
                    id="confirmDeleteBtn"
                    onclick="confirmDelete()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Delete Product
                </span>

            </button>

        </div>

    </div>
</div>


<div id="toast-container"></div>


<script>

let products = @json($products);

let editingId = null;
let deletingId = null;

let currentPage = 1;

const perPage = 5;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';


// -----------------------------------------
// Format Date
// -----------------------------------------

function formatDate(str)
{
    if (!str) return '—';

    return new Date(str).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}


// -----------------------------------------
// Pagination
// -----------------------------------------

function renderPagination(totalPages)
{
    let html = '';

    html += `
        <button
            ${currentPage == 1 ? 'disabled' : ''}
            onclick="changePage(${currentPage - 1})">
            Previous
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {

        html += `
            <button
                class="${i == currentPage ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button
            ${currentPage == totalPages ? 'disabled' : ''}
            onclick="changePage(${currentPage + 1})">
            Next
        </button>
    `;

    document.getElementById('pagination').innerHTML = html;
}


function changePage(page)
{
    currentPage = page;

    const search =
        document.getElementById('searchInput')
        .value
        .toLowerCase();

    render(
        products.filter(product =>
            product.item_name.toLowerCase().includes(search) ||
            (product.item_brand ?? '').toLowerCase().includes(search) ||
            (product.item_type ?? '').toLowerCase().includes(search)
        )
    );
}


// -----------------------------------------
// Render Products
// -----------------------------------------

function render(list)
{
    const tbody =
        document.getElementById('productBody');

    const empty =
        document.getElementById('emptyState');


    document.getElementById('product-count').textContent =
        list.length +
        ' Product' +
        (list.length !== 1 ? 's' : '');


    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        document.getElementById('pagination').innerHTML = '';

        return;
    }


    empty.style.display = 'none';


    const totalPages =
        Math.ceil(list.length / perPage);


    if (currentPage > totalPages) {
        currentPage = totalPages;
    }


    const start =
        (currentPage - 1) * perPage;


    const pageData =
        list.slice(start, start + perPage);


    tbody.innerHTML =
        pageData.map((product, i) => {

            const active =
                product.status == 1;


            return `
                <tr>

                    <td>
                        ${start + i + 1}
                    </td>

                    <td>
    ${
        product.item_image
        ? `
            <img
                src="{{ asset('') }}${product.item_image}"
                alt="${escHtml(product.item_name)}"
                style="
                    width:45px;
                    height:45px;
                    object-fit:cover;
                    border-radius:7px;
                    border:1px solid #e5e7eb;
                "
            >
        `
        : `
            <div style="
                width:45px;
                height:45px;
                border-radius:7px;
                background:#f5f5f5;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#999;
                font-size:10px;
            ">
                No Image
            </div>
        `
    }
</td>


                    <td>
                        <strong>
                            ${escHtml(product.item_name)}
                        </strong>

                        ${
                            product.item_description
                            ? `
                                <div style="
                                    font-size:11px;
                                    color:var(--faint);
                                    margin-top:3px;
                                ">
                                    ${escHtml(
                                        product.item_description.substring(0, 50)
                                    )}
                                    ${
                                        product.item_description.length > 50
                                        ? '...'
                                        : ''
                                    }
                                </div>
                            `
                            : ''
                        }
                    </td>


                    <td>
                        ${escHtml(product.item_brand ?? '—')}
                    </td>


                    <td>
                        ${escHtml(product.item_type ?? '—')}
                    </td>


                    <td>
                        ₹${Number(product.item_price).toFixed(2)}
                    </td>


                    <td>
                        ₹${Number(product.discount_on_item).toFixed(2)}
                    </td>


                    <td>
                        ${product.item_qty}
                    </td>


                    <td>

                        <div class="toggle-wrap">

                            <label class="toggle">

                                <input type="checkbox"
                                    ${active ? 'checked' : ''}
                                    onchange="
                                        toggleStatus(
                                            ${product.id},
                                            this.checked
                                        )
                                    ">

                                <span class="toggle-slider"></span>

                            </label>


                            <span class="
                                toggle-label
                                ${active ? 'active' : 'inactive'}
                            ">
                                ${active ? 'Active' : 'Inactive'}
                            </span>

                        </div>

                    </td>


                    <td>
                        ${formatDate(product.created_at)}
                    </td>


                    <td>

                        <div class="actions-cell"
                             style="justify-content:flex-end">

                            {{-- Edit --}}
                            <button
                                class="btn-icon"
                                title="Edit"
                                onclick="
                                    openEditModal(${product.id})
                                ">

                                <svg width="13"
                                     height="13"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path d="
                                        M11 4H4a2 2 0 0 0-2 2v14
                                        a2 2 0 0 0 2 2h14
                                        a2 2 0 0 0 2-2v-7
                                    "/>

                                    <path d="
                                        M18.5 2.5a2.121 2.121 0 0 1 3 3
                                        L12 15l-4 1 1-4 9.5-9.5z
                                    "/>

                                </svg>

                            </button>


                            {{-- Delete --}}
                            <button
                                class="btn-icon"
                                title="Delete"
                                style="
                                    color:var(--red);
                                    border-color:#f3c9c9
                                "
                                onclick="
                                    openDeleteModal(${product.id})
                                ">

                                <svg width="13"
                                     height="13"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <polyline points="
                                        3 6 5 6 21 6
                                    "/>

                                    <path d="
                                        M19 6l-1 14H6L5 6
                                    "/>

                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>

                                    <path d="
                                        M9 6V4h6v2
                                    "/>

                                </svg>

                            </button>

                        </div>

                    </td>

                </tr>
            `;

        }).join('');


    renderPagination(totalPages);
}


// -----------------------------------------
// Search
// -----------------------------------------

function filterProducts(q)
{
    currentPage = 1;

    q = q.toLowerCase();

    render(
        products.filter(product =>
            product.item_name.toLowerCase().includes(q) ||
            (product.item_brand ?? '').toLowerCase().includes(q) ||
            (product.item_type ?? '').toLowerCase().includes(q)
        )
    );
}


// -----------------------------------------
// Create Modal
// -----------------------------------------

function openCreateModal()
{
    editingId = null;

    document.getElementById('modalTitle').textContent =
        'New Product';

    document.getElementById('itemName').value = '';
    document.getElementById('itemBrand').value = '';
    document.getElementById('itemType').value = '';
    document.getElementById('itemDescription').value = '';

    document.getElementById('itemPrice').value = '';
    document.getElementById('discountOnItem').value = '';
    document.getElementById('itemQty').value = '';

    document.getElementById('itemImage').value = '';

    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('previewImage').src = '';

    document.getElementById('productActive').checked = true;

    document.querySelector('#saveBtn .btn-label')
        .textContent = 'Save Product';

    document.getElementById('formModal')
        .classList.add('open');
}

// -----------------------------------------
// Edit Modal
// -----------------------------------------

function openEditModal(id)
{
    const product =
        products.find(p => p.id === id);

    if (!product) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Product';

    document.getElementById('itemName').value =
        product.item_name ?? '';

    document.getElementById('itemBrand').value =
        product.item_brand ?? '';

    document.getElementById('itemType').value =
        product.item_type ?? '';

    document.getElementById('itemDescription').value =
        product.item_description ?? '';

    document.getElementById('itemPrice').value =
        product.item_price ?? 0;

    document.getElementById('discountOnItem').value =
        product.discount_on_item ?? 0;

    document.getElementById('itemQty').value =
        product.item_qty ?? 0;

    // Reset file input
    document.getElementById('itemImage').value = '';

    // Existing image
    if (product.item_image) {

        document.getElementById('previewImage').src =
            '{{ asset('') }}' + product.item_image;

        document.getElementById('imagePreview').style.display =
            'block';

    } else {

        document.getElementById('imagePreview').style.display =
            'none';

        document.getElementById('previewImage').src =
            '';

    }

    document.getElementById('productActive').checked =
        product.status == 1;

    document.querySelector('#saveBtn .btn-label')
        .textContent = 'Update Product';

    document.getElementById('formModal')
        .classList.add('open');
}

// -----------------------------------------
// Close Form Modal
// -----------------------------------------

function closeFormModal()
{
    document.getElementById('formModal')
        .classList.remove('open');
}


function handleBackdropClick(e)
{
    if (
        e.target ===
        document.getElementById('formModal')
    ) {
        closeFormModal();
    }
}


function previewItemImage(input)
{
    const preview =
        document.getElementById('previewImage');

    const previewContainer =
        document.getElementById('imagePreview');

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            preview.src = e.target.result;

            previewContainer.style.display =
                'block';

        };

        reader.readAsDataURL(input.files[0]);

    } else {

        preview.src = '';

        previewContainer.style.display =
            'none';
    }
}
// -----------------------------------------
// Save Product
// -----------------------------------------

async function saveProduct()
{
    const item_name =
        document.getElementById('itemName')
        .value
        .trim();

    const item_brand =
        document.getElementById('itemBrand')
        .value
        .trim();

    const item_type =
        document.getElementById('itemType')
        .value
        .trim();

    const item_description =
        document.getElementById('itemDescription')
        .value
        .trim();

    const item_price =
        document.getElementById('itemPrice')
        .value;

    const discount_on_item =
        document.getElementById('discountOnItem')
        .value || 0;

    const item_qty =
        document.getElementById('itemQty')
        .value;

    const status =
        document.getElementById('productActive').checked
        ? 1
        : 0;

    const itemImage =
        document.getElementById('itemImage').files[0];


    if (!item_name || !item_price || item_qty === '') {

        alert(
            'Please fill Item Name, Item Price and Quantity'
        );

        return;
    }


    const btn =
        document.getElementById('saveBtn');

    btn.classList.add('loading');
    btn.disabled = true;


    const url =
        editingId
            ? `/admin/products/${editingId}`
            : `/admin/products`;


    const formData = new FormData();

    formData.append(
        'item_name',
        item_name
    );

    formData.append(
        'item_brand',
        item_brand
    );

    formData.append(
        'item_type',
        item_type
    );

    formData.append(
        'item_description',
        item_description
    );

    formData.append(
        'discount_on_item',
        discount_on_item
    );

    formData.append(
        'item_price',
        item_price
    );

    formData.append(
        'item_qty',
        item_qty
    );

    formData.append(
        'status',
        status
    );


    // Add image if selected
    if (itemImage) {

        formData.append(
            'item_image',
            itemImage
        );

    }


    // Laravel PUT request with file upload
    if (editingId) {

        formData.append(
            '_method',
            'PUT'
        );

    }


    try {

        const res = await fetch(
            url,
            {
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },

                body: formData
            }
        );


        const data =
            await res.json();


        if (!res.ok) {

            if (data.errors) {

                const firstError =
                    Object.values(data.errors)[0][0];

                throw new Error(firstError);

            }

            throw new Error(
                data.message ??
                'Something went wrong'
            );

        }


        if (editingId) {

            const index =
                products.findIndex(
                    p => p.id === editingId
                );


            if (index > -1) {

                products[index] =
                    data.product;

            }


            toast(
                'Product updated successfully'
            );

        } else {

            products.unshift(
                data.product
            );


            toast(
                'Product created successfully'
            );

        }


        render(products);

        closeFormModal();


    } catch (err) {

        toast(
            err.message,
            'error'
        );

    } finally {

        btn.classList.remove('loading');

        btn.disabled = false;

    }
}

// -----------------------------------------
// Toggle Status
// -----------------------------------------

async function toggleStatus(id, checked)
{
    const product =
        products.find(
            p => p.id === id
        );


    if (!product) return;


    try {

        const res = await fetch(
            `/admin/products/${id}`,
            {

                method: 'PUT',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        CSRF,

                    'Accept':
                        'application/json'
                },

                body: JSON.stringify({

                    item_name:
                        product.item_name,

                    item_brand:
                        product.item_brand,

                    item_type:
                        product.item_type,

                    item_description:
                        product.item_description,

                    discount_on_item:
                        product.discount_on_item,

                    item_price:
                        product.item_price,

                    item_qty:
                        product.item_qty,
                        item_image:
    product.item_image,

                    status:
                        checked ? 1 : 0

                })

            }
        );


        const data =
            await res.json();


        if (!res.ok) {

            throw new Error(
                data.message ?? 'Failed'
            );

        }


        product.status =
            checked ? 1 : 0;


        render(products);


    } catch (err) {

        toast(
            err.message,
            'error'
        );

    }
}


// -----------------------------------------
// Delete Modal
// -----------------------------------------

function openDeleteModal(id)
{
    deletingId = id;

    document.getElementById('deleteModal')
        .classList.add('open');
}


function closeDeleteModal()
{
    deletingId = null;

    document.getElementById('deleteModal')
        .classList.remove('open');
}


function handleDeleteBackdropClick(e)
{
    if (
        e.target ===
        document.getElementById('deleteModal')
    ) {

        closeDeleteModal();

    }
}


// -----------------------------------------
// Delete Product
// -----------------------------------------

async function confirmDelete()
{
    if (!deletingId) return;


    const btn =
        document.getElementById(
            'confirmDeleteBtn'
        );


    btn.classList.add('loading');
    btn.disabled = true;


    try {

        const res =
            await fetch(
                `/admin/products/${deletingId}`,
                {

                    method: 'DELETE',

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF,

                        'Accept':
                            'application/json'

                    }

                }
            );


        const data =
            await res.json();


        if (!res.ok) {

            throw new Error(
                data.message ?? 'Failed'
            );

        }


        products =
            products.filter(
                p => p.id !== deletingId
            );


        render(products);

        closeDeleteModal();


        toast(
            'Product deleted successfully'
        );


    } catch (err) {

        toast(
            err.message,
            'error'
        );

    } finally {

        btn.classList.remove('loading');

        btn.disabled = false;

    }
}


// -----------------------------------------
// Toast
// -----------------------------------------

function toast(msg, type = 'success')
{
    alert(msg);
}


// -----------------------------------------
// Escape HTML
// -----------------------------------------

function escHtml(str)
{
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}


// -----------------------------------------
// Escape Key
// -----------------------------------------

document.addEventListener(
    'keydown',
    e => {

        if (e.key === 'Escape') {

            closeFormModal();

            closeDeleteModal();

        }

    }
);


// Initial Render
render(products);

</script>

@endsection