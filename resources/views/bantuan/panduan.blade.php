@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body justify-content-center">
        <div class="row">
            <div class="col-lg-3">
                <!-- A vertical navbar -->
                <nav class="navbar justify-content-center align-content-start bg-light navbar-light border-right sticky-top shadow-sm">
                    <!-- Links -->
                    <dl class="navbar-nav">
                        <dt class="nav-item">
                        <a class="nav-link" href="#link1">Link 1</a>
                        </dt>
                        <dd class="nav-item">
                        <a class="nav-link" href="#link2">Link 2</a>
                        </dd>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Link 3</a>
                        </li>
                    </dl>
                </nav>
            </div>
            <div class="col-lg-9 bg-light">
                <div class="card-body">
                    <h3 id="link1"># Content Goes Here</h3>
                    <p>Welcome To The Jungle</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
