<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="fas fa-table text-primary me-2"></i>Attendance Register</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= url('institute/attendance') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Marking
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Batch</label>
                    <select class="form-select" name="batch_id" id="batch_id" required>
                        <option value="">Select Batch</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?= $batch['id'] ?>"><?= e($batch['batch_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Month</label>
                    <select class="form-select" name="month" id="month">
                        <?php
                        $months = [
                            1 => 'January',
                            2 => 'February',
                            3 => 'March',
                            4 => 'April',
                            5 => 'May',
                            6 => 'June',
                            7 => 'July',
                            8 => 'August',
                            9 => 'September',
                            10 => 'October',
                            11 => 'November',
                            12 => 'December'
                        ];
                        $currentMonth = (int) date('m');
                        foreach ($months as $num => $name): ?>
                            <option value="<?= str_pad($num, 2, '0', STR_PAD_LEFT) ?>" <?= $num === $currentMonth ? 'selected' : '' ?>>
                                <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Year</label>
                    <select class="form-select" name="year" id="year">
                        <?php
                        $currentYear = (int) date('Y');
                        for ($y = $currentYear; $y >= $currentYear - 2; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>View
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" id="reportCard" style="display: none;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="attendanceTable">
                    <thead class="bg-light">
                        <!-- Headers will be generated dynamically -->
                    </thead>
                    <tbody>
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .att-cell {
        text-align: center;
        font-size: 0.85rem;
        width: 35px;
    }

    .status-present {
        color: #198754;
        font-weight: bold;
    }

    .status-absent {
        color: #dc3545;
        font-weight: bold;
    }

    .status-late {
        color: #ffc107;
        font-weight: bold;
    }

    .status-leave {
        color: #0dcaf0;
        font-weight: bold;
    }

    th.day-col {
        text-align: center;
        min-width: 30px;
        font-size: 0.8rem;
    }

    td.student-col {
        min-width: 200px;
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 1;
    }
</style>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        $('#filterForm').submit(function (e) {
            e.preventDefault();

            const batchId = $('#batch_id').val();
            const month = $('#month').val();
            const year = $('#year').val();

            if (!batchId) {
                Swal.fire('Error', 'Please select a batch', 'error');
                return;
            }

            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...').prop('disabled', true);

            $.ajax({
                url: '<?= url('api/attendance/monthly') ?>',
                type: 'GET',
                data: { batch_id: batchId, month: month, year: year },
                success: function (response) {
                    if (response.success) {
                        renderTable(response.data);
                        $('#reportCard').show();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to fetch attendance report', 'error');
                },
                complete: function () {
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });

        function renderTable(data) {
            const daysInMonth = data.daysInMonth;
            const students = data.students;
            const attendance = data.attendance;

            const thead = $('#attendanceTable thead');
            const tbody = $('#attendanceTable tbody');

            // Generate Header
            let headerRow = '<tr><th class="student-col">Student Name</th>';
            for (let i = 1; i <= daysInMonth; i++) {
                headerRow += `<th class="day-col">${i}</th>`;
            }
            headerRow += '</tr>';
            thead.html(headerRow);

            // Generate Body
            tbody.empty();
            if (students.length === 0) {
                tbody.html(`<tr><td colspan="${daysInMonth + 1}" class="text-center py-4">No students found</td></tr>`);
                return;
            }

            students.forEach(student => {
                let row = `<tr><td class="student-col fw-bold">${student.first_name} ${student.last_name}</td>`;

                for (let i = 1; i <= daysInMonth; i++) {
                    let cellContent = '-';
                    let cellClass = '';

                    if (attendance[student.id] && attendance[student.id][i]) {
                        const status = attendance[student.id][i].status;
                        if (status === 'present') { cellContent = 'P'; cellClass = 'status-present'; }
                        else if (status === 'absent') { cellContent = 'A'; cellClass = 'status-absent'; }
                        else if (status === 'late') { cellContent = 'L'; cellClass = 'status-late'; }
                        else if (status === 'leave') { cellContent = 'LV'; cellClass = 'status-leave'; }
                    }

                    row += `<td class="att-cell ${cellClass}">${cellContent}</td>`;
                }
                row += '</tr>';
                tbody.append(row);
            });
        }
    });
</script>