  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">NYHS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">Smart Boy</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <!-- <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->
                  <li class="nav-item">
                      <a href="index.php" class="nav-link">
                          <i class="nav-icon fas fa-home"></i>
                          <p>
                              ទំព័រដើម
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">បញ្ជីសារពើភណ្ឌ</li>
                  <li class="nav-item">
                      <a href="book.php" class="nav-link">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                          សៀវភៅ
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="import.php" class="nav-link">
                          <i class="nav-icon fas fa-server"></i>
                          <p>
                          ការនាំចូល
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">បញ្ជីសារពើភណ្ឌ</li>
                  <li class="nav-item">
                      <a href="read.php" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                          អានសៀវភៅ
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="borrow.php" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                          ខ្ចីសៀវភៅ
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">Manage</li>

                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              សិស្ស
                              <i class="fas fa-angle-left right"></i>
                              <!-- <span class="badge badge-info right">6</span> -->
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="class.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ថ្នាក់</p>
                              </a>

                              <a href="student.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>សិស្សទាំងអស់</p>
                              </a>

                          </li>

                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              អ្នកនិពន្ធ
                              <i class="fas fa-angle-left right"></i>
                              <!-- <span class="badge badge-info right">6</span> -->
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="teacher.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>គ្រូ</p>
                              </a>
                              <a href="category.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ប្រភេទ</p>
                              </a>
                              <a href="supplier.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>អ្នក​ផ្គត់ផ្គង់</p>
                              </a>
                              <a href="author.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>អ្នកនិពន្ធ</p>
                              </a>
                              <a href="print.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>បោះពុម្ព</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
  <script>
var url = window.location;
const allLinks = document.querySelectorAll('.nav-item a');
const currentLink = [...allLinks].filter(e => {
    return e.href == url;
});

if (currentLink.length > 0) {
    currentLink[0].classList.add("active");
    currentLink[0].closest(".nav-treeview").style.display = "block";
    currentLink[0].closest(".has-treeview").classList.add("active", "menu-open");
}
  </script>