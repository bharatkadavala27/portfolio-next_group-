<?php $__env->startSection('title', 'Downloads'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Removed color: black!important; to fix invisible text */
        }

        .card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        div:hover {
            cursor: pointer;
        }

        a:hover {
            text-decoration: none;
            border: none;
        }
    </style>

    <div class="container my-5">
        <h3 class="mb-4">Explore by Document Category</h3>


        <div class="row row-cols-1 row-cols-md-3 g-3" name="document-categories">
            <?php if(isset($categories) && $categories->count() > 0): ?>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_null($category->parent_id)): ?> <!-- Only show main categories -->
                        <div class="col">
                            <a href="<?php echo e(url('category/' . $category->id . '/documents')); ?>" class="text-decoration-none text-dark">
                                <div id="myButton" class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                                    <?php if($category->image): ?>
                                        <img src="<?php echo e(asset('document_categories/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>"
                                            class="me-3" style="width: 50px; height: 50px; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="bi bi-box-seam fs-3 text-primary me-3"></i>
                                    <?php endif; ?>
                                    <div class="flex-grow-1" id="myButton">
                                        <h5 class="mb-1" id="myButton"><?php echo e($category->name); ?></h5>
                                        <?php if($category->description): ?>
                                            <p class="mb-0 text-muted small"><?php echo Str::limit($category->description, 100); ?></p>
                                        <?php endif; ?>
                                        <style>
                                            #myButton:hover {
                                                /* background-color: red; */
                                                color: black;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col">
                    <div class="alert alert-warning">No categories available.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('downloadAllBtn').addEventListener('click', function () {
            // You can replace this with your actual download all logic
            alert('Download All functionality to be implemented.');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2026 -BK\NEXT SOLUTION\FEBRUARY\28-02-2026\next-solutions new\resources\views/frontend/pages/download.blade.php ENDPATH**/ ?>