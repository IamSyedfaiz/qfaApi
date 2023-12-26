@php
use App\Models\Role;

$roles = Role::all();

@endphp

{{-- {{ $roles }} --}}
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('public/admin/assets/img/logo.jpg') }}" alt="logo" class="img-fluid">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        {{-- {{ auth()->user()->role->lead == 'Y' }} --}}
        @if (@auth()->user()->role->lead == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.add.leads') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Add Leads">Add Leads</div>
            </a>
        </li>
        <!-- Tables -->
        <li class="menu-item">
            <a href="{{ route('admin.all.leads') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="TAll Leads">All Leads</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.all.api.leads') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="TAll Leads">All Api Leads</div>
            </a>
        </li>
        @endif
        @if (@auth()->user()->role->user == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.user.management') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Add Leads">User management</div>
            </a>
        </li>
        @endif
        @if (@auth()->user()->role->meeting == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.all.leads') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Add Leads">Meetings</div>
            </a>
        </li>
        @endif
        @if (@auth()->user()->role->proposal == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.all.leads') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-gift"></i>
                <div data-i18n="Add Leads">Proposals</div>
            </a>
        </li>
        @endif
        {{-- @if (@auth()->user()->role->certificate == 'Y' || auth()->user()->id == 1)
            <li class="menu-item ">
                <a href="{{ route('admin.add.certificate', ['id' => 1]) }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-plus"></i>
        <div data-i18n="Add Leads">Add Certificate</div>
        </a>
        </li>
        @endif --}}
        @if (@auth()->user()->role->certificate == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.all.certificate') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-patch-check"></i>
                <div data-i18n="Add Leads">All Certificate</div>
            </a>
        </li>
        @endif
        @if (@auth()->user()->role->certificate == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('get.document') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-folder"></i>
                <div data-i18n="Add Leads">All Document</div>
            </a>
        </li>
        @endif
        @if (@auth()->user()->role->account == 'Y' || auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('get.payment') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-wallet"></i>
                <div data-i18n="Add Leads">All Payment</div>
            </a>
        </li>
        @endif
        @if (auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.add.standard') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-star"></i>
                <div data-i18n="Add Leads">Standard manage</div>
            </a>
        </li>
        @endif
        @if (auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.add.accreditation') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-view-stacked"></i>
                <div data-i18n="Add Leads">Accreditation manage</div>
            </a>
        </li>
        @endif
        @if (auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.add.status') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-command"></i>
                <div data-i18n="Add Leads">Status manage</div>
            </a>
        </li>
        @endif
        @if (auth()->user()->id == 1)
        <li class="menu-item ">
            <a href="{{ route('admin.add.leadSource') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-x-diamond-fill"></i>
                <div data-i18n="Add Leads">Lead Source manage</div>
            </a>
        </li>
        @endif
    </ul>
</aside>