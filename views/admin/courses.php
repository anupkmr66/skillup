<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-book me-2"></i>Manage Courses
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <i class="fas fa-plus me-2"></i>Add New Course
            </button>
        </div>

        <div class="table-responsive">
            <table class="table" id="coursesTable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Duration (Months)</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= e($course['course_code']) ?></td>
                            <td><?= e($course['course_name']) ?></td>
                            <td><?= e($course['category']) ?></td>
                            <td><?= e($course['duration']) ?></td>
                            <td>
                                <?php 
                                    $regPrice = $course['regular_price'] ?? 0;
                                    $offPrice = $course['offer_price'] ?? $course['fee'] ?? 0;
                                ?>
                                <?php if($regPrice > $offPrice): ?>
                                    <small class="text-muted text-decoration-line-through">₹<?= number_format($regPrice, 2) ?></small>
                                <?php endif; ?>
                                ₹<?= number_format($offPrice, 2) ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= ($course['status'] ?? 'active') === 'active' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($course['status'] ?? 'active') ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info view-btn" title="View"
                                    data-bs-toggle="modal" data-bs-target="#viewCourseModal"
                                    data-course="<?= htmlspecialchars(json_encode($course), ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning edit-btn" title="Edit"
                                    data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                    data-course="<?= htmlspecialchars(json_encode($course), ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteCourseModal"
                                    data-id="<?= $course['id'] ?>" data-name="<?= e($course['course_name']) ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/courses/create') ?>" method="POST">
                <?= CSRF::field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="course_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="course_code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" placeholder="e.g. Programming">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (Months) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duration" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Regular Price <span class="text-muted">(Optional)</span></label>
                            <input type="number" class="form-control" name="regular_price" min="0" step="0.01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Offer Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="offer_price" required min="0" step="0.01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/courses/update') ?>" method="POST">
                <?= CSRF::field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="course_name" id="edit_course_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="course_code" id="edit_course_code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="edit_category">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (Months) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duration" id="edit_duration" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Regular Price</label>
                            <input type="number" class="form-control" name="regular_price" id="edit_regular_price" min="0" step="0.01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Offer Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="offer_price" id="edit_offer_price" required min="0" step="0.01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Course Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/courses/delete') ?>" method="POST">
                <?= CSRF::field() ?>
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-body">
                    <p>Are you sure you want to delete the course <strong id="delete_name"></strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone. If students are enrolled, you cannot delete it.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            $('#coursesTable').DataTable();

            // Edit Modal Population
            $('.edit-btn').click(function() {
                var course = $(this).data('course');
                // Ensure course object exists
                if (!course) {
                    console.error("Course data missing");
                    return;
                }
                
                $('#edit_id').val(course.id);
                $('#edit_course_name').val(course.course_name);
                $('#edit_course_code').val(course.course_code);
                $('#edit_category').val(course.category);
                $('#edit_duration').val(course.duration);
                $('#edit_regular_price').val(course.regular_price || 0);
                // Fallback for offer_price -> fee -> 0
                $('#edit_offer_price').val(course.offer_price || course.fee || 0);
                $('#edit_status').val(course.status);
                $('#edit_description').val(course.description);
            });

            // Delete Modal Population
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                console.log("Deleting course ID:", id); // Debug
                $('#delete_id').val(id);
                $('#delete_name').text(name);
            });

            // View Modal Population
            $('.view-btn').click(function() {
                var course = $(this).data('course');
                if (!course) return;

                $('#view_course_name').text(course.course_name);
                $('#view_course_code').text(course.course_code);
                $('#view_category').text(course.category || 'N/A');
                $('#view_duration').text(course.duration + ' Months');
                
                // Price Display Logic
                var regPrice = parseFloat(course.regular_price || 0);
                var offPrice = parseFloat(course.offer_price || course.fee || 0);
                
                var priceHtml = '';
                if(regPrice > offPrice) {
                    priceHtml += '<small class="text-muted text-decoration-line-through me-2">₹' + 
                        regPrice.toLocaleString('en-IN', {minimumFractionDigits: 2}) + '</small>';
                }
                priceHtml += '<span class="text-success fw-bold">₹' + 
                    offPrice.toLocaleString('en-IN', {minimumFractionDigits: 2}) + '</span>';
                
                $('#view_fee').html(priceHtml);
                
                $('#view_status').html('<span class="badge badge-' + 
                    (course.status === 'active' ? 'success' : 'danger') + '">' + 
                    (course.status.charAt(0).toUpperCase() + course.status.slice(1)) + '</span>');
                
                $('#view_description').text(course.description || 'No description available.');
            });
        });
    });
</script>

<!-- View Course Modal -->
<div class="modal fade" id="viewCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Course Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Course Name</th>
                        <td id="view_course_name"></td>
                    </tr>
                    <tr>
                        <th>Course Code</th>
                        <td id="view_course_code"></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td id="view_category"></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td id="view_duration"></td>
                    </tr>
                    <tr>
                        <th>Fee Structure</th>
                        <td id="view_fee"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="view_status"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td id="view_description"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
