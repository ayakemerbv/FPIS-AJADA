@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <ul>
                <li><a href="{{ route('employee.requests') }}">📋 Просмотр заявок</a></li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="dashboard-content">
            <h2>Добро пожаловать в панель сотрудника!</h2>
            <p>Вы можете управлять заявками студентов.</p>
        </main>
    </div>

    <!-- Стили -->
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            background: #34495e;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background: #1abc9c;
        }

        .dashboard-content {
            flex: 1;
            padding: 20px;
        }
    </style>
@endsection

