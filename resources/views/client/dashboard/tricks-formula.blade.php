@extends('client.layout.app')

@section('style')
<style>
    .dash{
        padding:30px 0 80px;
        min-height:100vh;
        background:#f8fafc;
    }
    .page-header{
        margin-bottom:24px;
    }
    .page-title{
        font-size:2rem;
        font-weight:800;
        color:#111827;
        margin-bottom:6px;
    }
    .page-subtitle{
        color:#6b7280;
        font-size:.95rem;
        margin:0;
    }
    .score-card{
        background:#fff;
        border-radius:20px;
        padding:24px;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
    }
    .score-tabs{
        display:flex;
        gap:12px;
        margin-bottom:24px;
        flex-wrap:wrap;
    }
    .score-tab{
        border:none;
        padding:12px 22px;
        border-radius:12px;
        background:#eef2ff;
        color:#4338ca;
        font-weight:700;
    }
    .score-tab.active{
        background:linear-gradient(135deg,#2563eb,#4f46e5);
        color:#fff;
    }
    .filter-wrap{
        display:flex;
        gap:16px;
        margin-bottom:24px;
        flex-wrap:wrap;
    }
    .filter-box{
        min-width:220px;
        flex:1;
    }
    .filter-label{
        display:block;
        margin-bottom:8px;
        font-size:.85rem;
        font-weight:600;
        color:#6b7280;
    }
    .filter-control{
        width:100%;
        height:48px;
        border-radius:12px;
        border:1px solid #dbe3ef;
        padding:0 14px;
    }
    .table-wrap{
        overflow-x:auto;
    }
    .score-table{
        width:100%;
        border-collapse:collapse;
        min-width:850px;
    }
    .score-table thead th{
        background:#f3f4f6;
        padding:14px;
        font-size:.85rem;
        color:#6b7280;
        text-transform:uppercase;
    }
    .score-table tbody td{
        padding:16px 14px;
        border-bottom:1px solid #eef2f7;
    }
    .badge{
        padding:7px 14px;
        border-radius:999px;
        font-size:.78rem;
        font-weight:700;
        display:inline-block;
    }
    .badge-name{
        background:#dbeafe;
        color:#1d4ed8;
    }
    .badge-type{
        background:rgba(79,70,229,.12);
        color:#4f46e5;
    }
    .badge-mode{
        background:rgba(37,99,235,.10);
        color:#2563eb;
    }
    .badge-level{
        background:rgba(16,185,129,.12);
        color:#059669;
    }
    .correct{
        color:#16a34a;
        font-weight:700;
    }
    .wrong{
        color:#dc2626;
        font-weight:700;
    }
    .skip{
        color:#d97706;
        font-weight:700;
    }
    .empty{
        text-align:center;
        padding:40px;
        color:#6b7280;
        font-weight:600;
    }



.tricks-list{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.trick-card{
    background:#fff;
    border-radius:10px;
    padding:20px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    transition:.3s;
}

.trick-card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

.trick-card h3{
    color:#0d6efd;
    margin-bottom:10px;
}

.trick-card p{
    margin:8px 0;
    color:#555;
    line-height:1.6;
}
</style>
@endsection

@section('content')
<div class="dash">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title">Tricks And Formula</h1>
            <p class="page-subtitle">
                Learn quick mathematical tricks and formulas for faster calculations.
            </p>
        </div>

        <div class="tricks-list">

            <div class="trick-card">
                <h3>1. Multiplication by 11</h3>
                <p><strong>Formula:</strong> 23 × 11 = 253</p>
                <p><strong>Trick:</strong> Add the two digits (2+3=5) and place the sum between them.</p>
            </div>

            <div class="trick-card">
                <h3>2. Square of Numbers Ending in 5</h3>
                <p><strong>Formula:</strong> 35² = 1225</p>
                <p><strong>Trick:</strong> Multiply 3 × 4 = 12 and append 25.</p>
            </div>

            <div class="trick-card">
                <h3>3. Percentage Trick</h3>
                <p><strong>Formula:</strong> 10% of 250 = 25</p>
                <p><strong>Trick:</strong> Move the decimal one place to the left.</p>
            </div>

            <div class="trick-card">
                <h3>4. Divisibility by 3</h3>
                <p><strong>Formula:</strong> Sum of digits divisible by 3.</p>
                <p><strong>Example:</strong> 234 → 2+3+4 = 9 ✓</p>
            </div>

            <div class="trick-card">
                <h3>5. Divisibility by 9</h3>
                <p><strong>Formula:</strong> Sum of digits divisible by 9.</p>
                <p><strong>Example:</strong> 729 → 7+2+9 = 18 ✓</p>
            </div>

            <div class="trick-card">
                <h3>6. Cube of 5</h3>
                <p><strong>Formula:</strong> 5³ = 125</p>
                <p><strong>Remember:</strong> 5 × 5 × 5 = 125.</p>
            </div>

            <div class="trick-card">
                <h3>7. Speed Addition</h3>
                <p><strong>Example:</strong> 48 + 52 = 100</p>
                <p><strong>Trick:</strong> Pair numbers that make 100.</p>
            </div>

            <div class="trick-card">
                <h3>8. Table of 9</h3>
                <p><strong>Example:</strong> 9 × 7 = 63</p>
                <p><strong>Trick:</strong> Use finger counting or subtract from multiples of 10.</p>
            </div>

            <div class="trick-card">
                <h3>9. Average Formula</h3>
                <p><strong>Formula:</strong> Average = Sum ÷ Number of Values</p>
            </div>

            <div class="trick-card">
                <h3>10. Simple Interest</h3>
                <p><strong>Formula:</strong> SI = (P × R × T) / 100</p>
            </div>

        </div>

    </div>
</div>
@endsection

@section('script')

@endsection