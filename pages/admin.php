<?php

if (!User::current()->isAdmin()) {
	Session::redirect("./");
}

include "pages/header.php";

$bannerText = "Administration";
include "pages/banner.php"; ?>

<div class="huge-padding"></div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="info-property-title form-group">System Users</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="info-property-type">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>First Name</strong></th>
              <th><strong>Last Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Delete User?</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>First</td>
              <td>Last</td>
              <td>emaillllll</td>
              <td><div><a class="remove-icon" href=""><i class="fa fa-times"></i></a></div></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="info-property-title form-group">Property Summary</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="info-property-type">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>Property Name</strong></th>
              <th><strong>Total Bookings</strong></th>
              <th><strong>Average Rating</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>LAKEVIEW</td>
              <td>0</td>
              <td>0</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="info-property-title form-group">Supplier Summary</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="info-property-type">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>First Name</strong></th>
              <th><strong>Last Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Total Bookings</strong></th>
              <th><strong>Average Rating</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>S</td>
              <td>K</td>
              <td>e@p.ca</td>
              <td>0</td>
              <td>0</td>
              <td>0</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="info-property-title form-group">Consumer Summary</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="info-property-type">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>First Name</strong></th>
              <th><strong>Last Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Requested Bookings</strong></th>
              <th><strong>Confirmed Bookings </strong></th>
              <th><strong>Rejected Bookings</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>S</td>
              <td>K</td>
              <td>e@p.ca</td>
              <td>0</td>
              <td>0</td>
              <td>0</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="huge-padding"></div>

<?php

include "pages/footer.php";