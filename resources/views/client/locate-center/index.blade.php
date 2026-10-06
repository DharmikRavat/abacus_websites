@extends('client.layout.app')

@section('style')
<style>

.center-search-box{
    background:#fff;
    padding:20px;
    border-radius:15px;

}

.filter-select{
    height:45px;
    font-size:18px;
    border-radius:10px;
}

.search-btn{
    min-width:350px;
    height:45px;
    font-size:18px;
    border-radius:10px;
    background:#1677ff;
    border:none;
}

.search-btn:hover{
    background:#005de0;
}

.center-card{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,.10);
    margin-bottom:30px;
    transition:.3s;
}

.center-card:hover{
    transform:translateY(-5px);
}

.center-header{
    background:#1F3971;
    color:#fff;
    padding:20px;
}

.center-body{
    padding:20px;
}

.center-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:5px;
}

.center-location{
    color:#666;
    margin-bottom:15px;
}

.center-info{
    margin-bottom:10px;
}

.center-phone{
    display:inline-block;
    background:#1677ff;
    color:#fff;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
}

.center-phone:hover{
    color:#fff;
}

.no-results{
    text-align:center;
    padding:60px 20px;
    background:#fff;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.no-results i{
    font-size:50px;
    color:#1F3971;
    margin-bottom:15px;
}

.no-results h4{
    margin:15px 0 10px;
    color:#1F3971;
    font-weight:600;
}

.no-results p{
    color:#777;
    margin:0;
}

</style>
@endsection
@section('content')
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h1 class="text-center">LOCATE CENTER</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="{{ route('home')}}">Home</a></li>
                                <li>LOCATE CENTER</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
        <!--About Area Start-->
<div class="about-area mt-70 pb-70">
    <div class="container">
        <h3>Locate Center</h3>

        <div class="center-search-box">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <select id="country" class="form-control filter-select">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <select id="state" class="form-control filter-select">
                        <option value="">Select State</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <select id="district" class="form-control filter-select">
                        <option value="">Select District</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button id="searchBtn" class="btn btn-primary search-btn">
                    Search Centers
                </button>
            </div>

        </div>

        <div class="row mt-5" id="centerResults"></div>

    </div>
</div>
    <!--End of About Area-->

@endsection
@section('script')

<script>
    const centers = @json($centers);

const countrySelect = document.getElementById('country');
const stateSelect = document.getElementById('state');
const districtSelect = document.getElementById('district');
const resultsDiv = document.getElementById('centerResults');

function showPlaceholder() {
    resultsDiv.innerHTML = `
        <div class="col-12">
            <div class="no-results">
                <i class="fa fa-map-marker"></i>
                <h4>Select Location</h4>
                <p>Please select Country, State and District to find a Center</p>
            </div>
        </div>
    `;
}

function uniqueValues(key, data) {
    return [...new Set(data.map(item => item[key]))];
}

function populateCountries() {

    countrySelect.innerHTML =
        '<option value="">Select Country</option>';

    uniqueValues('country_name', centers).forEach(country => {

        countrySelect.innerHTML +=
            `<option value="${country}">${country}</option>`;
    });
}

countrySelect.addEventListener('change', function () {

    stateSelect.innerHTML =
        '<option value="">Select State</option>';

    districtSelect.innerHTML =
        '<option value="">Select District</option>';

    const states = uniqueValues(
        'state_name',
        centers.filter(c => c.country_name === this.value)
    );

    states.forEach(state => {

        stateSelect.innerHTML +=
            `<option value="${state}">${state}</option>`;
    });

    showPlaceholder();
});

stateSelect.addEventListener('change', function () {

    districtSelect.innerHTML =
        '<option value="">Select District</option>';

    const districts = uniqueValues(
        'district_name',
        centers.filter(c =>
            c.country_name === countrySelect.value &&
            c.state_name === this.value
        )
    );

    districts.forEach(district => {

        districtSelect.innerHTML +=
            `<option value="${district}">${district}</option>`;
    });

    showPlaceholder();
});

document.getElementById('searchBtn').addEventListener('click', function () {

    if (!countrySelect.value) {
        alert('Please select Country');
        return;
    }

    if (!stateSelect.value) {
        alert('Please select State');
        return;
    }

    if (!districtSelect.value) {
        alert('Please select District');
        return;
    }

    const filtered = centers.filter(center =>
        center.country_name === countrySelect.value &&
        center.state_name === stateSelect.value &&
        center.district_name === districtSelect.value
    );

    renderCenters(filtered);
});

function renderCenters(data) {

    if (data.length === 0) {

        resultsDiv.innerHTML = `
            <div class="col-12">
                <div class="no-results">
                    <i class="fa fa-search"></i>
                    <h4>No Centers Found</h4>
                    <p>No center is available for the selected location.</p>
                </div>
            </div>
        `;

        return;
    }

    let html = '';

    data.forEach(center => {

        html += `
        <div class="col-md-6 col-lg-4">

            <div class="center-card">

                <div class="center-header">
                    <div class="center-title">
                        ${center.center_name}
                    </div>
                </div>

                <div class="center-body">

                    <div class="center-location">
                        <i class="fa fa-map-marker"></i>
                        ${center.center_address}
                    </div>

                    <div class="center-info">
                        <strong>Country:</strong>
                        ${center.country_name}
                    </div>

                    <div class="center-info">
                        <strong>State:</strong>
                        ${center.state_name}
                    </div>

                    <div class="center-info">
                        <strong>District:</strong>
                        ${center.district_name}
                    </div>

                    <div class="center-info">
                        <strong>Trainer:</strong>
                        ${center.assigned_teacher_name}
                    </div>

                    <div class="center-info">
                        ${center.assigned_teacher_about}
                    </div>

                    <div class="mt-3">
                        <a href="tel:${center.center_contact}" class="center-phone">
                            <i class="fa fa-phone"></i>
                            ${center.center_contact}
                        </a>
                    </div>

                </div>

            </div>

        </div>`;
    });

    resultsDiv.innerHTML = html;
}

populateCountries();
showPlaceholder();
</script>

@endsection