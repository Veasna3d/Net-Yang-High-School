 <?php include'dbConnection.php'; ?>
 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <?php
       $sql = "SELECT * FROM brand";
       $result = $conn->prepare($sql);
       $result->execute();
       while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
       ?>
      <a href="index.php" class="brand-link">
          <img src="upload/<?php echo $row["image"]; ?>" alt="" class="brand-image elevation-4" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo $row["name"]; ?></span>
      </a>
      <?php } ?>

      <!-- Sidebar -->
      <div class="sidebar">


          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                  <li class="nav-header">ការកំណត់</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-list"></i>
                          <p>
                              បញ្ជីអ្នកប្រើប្រាស់
                              <i class="fas fa-angle-left right"></i>
                              <!-- <span class="badge badge-info right">6</span> -->
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="teacher.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>បញ្ជីគ្រូ</p>
                              </a>
                              <a href="student.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>បញ្ជីសិស្ស</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-list"></i>
                          <p>
                              កំណត់ទូទៅ
                              <i class="fas fa-angle-left right"></i>
                              <!-- <span class="badge badge-info right">6</span> -->
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="brand.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ឈ្មោះសាលា</p>
                              </a>
                              <a href="class.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ថ្នាក់រៀន</p>
                              </a>
                              <a href="category.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ប្រភេទសៀវភៅ</p>
                              </a>
                              <a href="supplier.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>អ្នក​ផ្គត់ផ្គង់</p>
                              </a>

                              <a href="print.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>គ្រឹះស្ថាន​ នឹង​ ទីតាំងបោះពុម្ព</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">របាយការណ៍</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              របាយការណ៍
                              <i class="fas fa-angle-left right"></i>
                              <!-- <span class="badge badge-info right">6</span> -->
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                          <a href="r_book.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>បញ្ជីសារពើភណ្ឌ</p>
                              </a>
                              <a href="r_read.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>ការអានសៀវភៅ</p>
                              </a>
                              <a href="sr_borrow.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>សិស្សខ្ចីសៀវភៅ</p>
                              </a>
                              <a href="tr_borrow.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>គ្រូខ្ចីសៀវភៅ</p>
                              </a>

                    
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">សុវត្ថិភាព</li>
                  <li class="nav-item">
                      <a href="user.php" class="nav-link">
                      <i class="fa fa-lock"></i>
                          <p>
                              អ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ
                          </p>
                      </a>
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