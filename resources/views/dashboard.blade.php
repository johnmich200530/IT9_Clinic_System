<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>


<body>
<div class ='container'>
    
</div>

<div class="app-sidebar">
  <a class="app-sidebar__brand" a href="/welcome">
    <span class="app-sidebar__brand-text">Clinic Apppointment Management</span>
  </a>

  <div class="app-sidebar__nav">
  <a href="/dashboard" class="app-sidebar__link">Dashboard</a>
  <a href="/appointments" class="app-sidebar__link">Services</a>
  <a href="/payments" class="app-sidebar__link">Doctors</a>
  <a href="/payments" class="app-sidebar__link">Patients</a>
  <a href="/payments" class="app-sidebar__link">Apppointments</a>
  <a href="/payments" class="app-sidebar__link">Logout</a>
</div>


</body>

</html>

