<?php

if (!User::current()->isAdmin()) {
	Session::redirect("./");
}

include "pages/header.php";

$bannerText = "Administration";
include "pages/banner.php"; ?>

<div class="huge-padding"></div>

<div class="container">
<div class="row">
    <ul id="myTabs" class="nav nav-tabs nav-justified" role="tablist">
        <li role="presentation" class="active"><a href="#users" id="users-tab" role="tab" data-toggle="tab" aria-controls="users" aria-expanded="true">System Users</a>
        </li>
        <li role="presentation"><a href="#propertysum" role="tab" id="propertysum-tab" data-toggle="tab" aria-controls="propertysum">Property Summary</a>
        </li>
        <li role="presentation"><a href="#suppliersummary" role="tab" id="suppliersummary-tab" data-toggle="tab" aria-controls="suppliersummary">Supplier Summary</a>
        </li>
        <li role="presentation"><a href="#consumersummary" role="tab" id="consumersummary-tab" data-toggle="tab" aria-controls="consumersummary">Consumer Summary</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="users" aria-labelledby="users-tab">
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
              <td><div><a class="font-red" href=""><i class="fa fa-times"></i></a></div></td>
            </tr>
          </tbody>
        </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="propertysum" aria-labelledby="propertysum-tab">
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
        <div role="tabpanel" class="tab-pane fade" id="propertysum" aria-labelledby="propertysum-tab">
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

        <div role="tabpanel" class="tab-pane fade" id="suppliersummary" aria-labelledby="suppliersummary-tab">
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
            </tr>
          </tbody>
        </table>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="consumersummary" aria-labelledby="consumersummary-tab">
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