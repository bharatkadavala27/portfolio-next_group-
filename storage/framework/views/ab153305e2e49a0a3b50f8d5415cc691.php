<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h4>Add Download </h4>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.documents-sections.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="document_name" class="form-label">Download Name </label>
                    <input type="text" name="document_name" class="form-control" id="document_name"
                        value="<?php echo e(old('document_name')); ?>">
                    <small class="text-danger d-none" id="docNameError">Download name is required</small>
                    <?php $__errorArgs = ['document_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="document_type" class="form-label">Download Type</label>
                    <select name="document_type" class="form-control" id="document_type">
                        <option value="">Select Download Type</option>
                        <?php $__currentLoopData = $documentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" <?php echo e(old('document_type') == $type->id ? 'selected' : ''); ?>>
                                <?php echo e($type->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-danger d-none" id="docTypeError">Download type is required</small>
                    <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="document_category" class="form-label">Download Category</label>
                    <select name="document_category" class="form-control" id="document_category">
                        <option value="">Select Download Category</option>
                        <?php $__currentLoopData = $documentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // disable option if this category has children (i.e. it's a main category with sub-categories)
                                $isParent = $category->children && $category->children->count() > 0;
                            ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(old('document_category') == $category->id ? 'selected' : ''); ?> <?php echo e($isParent ? 'disabled' : ''); ?>>
                                <?php echo $category->formatted_name; ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-danger d-none" id="docCategoryError">Download category is required</small>
                    <?php $__errorArgs = ['document_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="document_brand" class="form-label">Download Brand</label>
                    <select name="document_brand" class="form-control" id="document_brand">
                        <option value="">Select Download Brand</option>
                        <?php $__currentLoopData = $documentBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->id); ?>" <?php echo e(old('document_brand') == $brand->id ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-danger d-none" id="docBrandError">Download brand is required</small>
                    <?php $__errorArgs = ['document_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>






                <!-- Filter Name(s) and Options (dynamic) -->
                <div class="mb-3">
                    <label class="form-label">Filters</label>

                    <div id="filters-container">
                        
                        <?php
                            $oldFilters = old('filter_id', []);
                            $oldOptions = old('filter_option_id', []);
                            if (!is_array($oldFilters) || empty($oldFilters)) {
                                $oldFilters = [''];
                            }
                            if (!is_array($oldOptions) || empty($oldOptions)) {
                                $oldOptions = [''];
                            }
                        ?>

                        <?php $__currentLoopData = $oldFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $oldFilterValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="filter-pair mb-2 d-flex align-items-start" data-index="<?php echo e($i); ?>">
                                <select name="filter_id[]" class="form-control me-2 filter-select">
                                    <option value="">Select Filter</option>
                                    <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($filter->id); ?>" <?php echo e($oldFilterValue == $filter->id ? 'selected' : ''); ?>>
                                            <?php echo e($filter->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <select name="filter_option_id[]" class="form-control me-2 filter-option-select">
                                    <option value="">Select Option</option>
                                    <?php if(!empty($oldOptions[$i])): ?>
                                        <?php
                                            $selectedFilter = $filters->firstWhere('id', $oldFilterValue);
                                        ?>
                                        <?php if($selectedFilter && $selectedFilter->options): ?>
                                            <?php $__currentLoopData = $selectedFilter->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt->id); ?>" <?php echo e($oldOptions[$i] == $opt->id ? 'selected' : ''); ?>>
                                                    <?php echo e($opt->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </select>

                                <button type="button" class="btn btn-success btn-add me-1" title="Add">+</button>
                                <button type="button" class="btn btn-danger btn-remove" title="Remove">−</button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php $__errorArgs = ['filter_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['filter_option_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>



                <div class="mb-3">
                    <label for="documents" class="form-label">Documents</label>
                    <input type="file" name="documents[]" class="form-control" multiple>
                    <small class="text-danger d-none" id="fileError">Upload document files OR provide file link</small>
                    <?php $__errorArgs = ['documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['documents.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="file_link" class="form-label">File Link (Optional)</label>
                    <input type="url" name="file_link" class="form-control" id="file_link" value="<?php echo e(old('file_link')); ?>"
                        placeholder="Enter file URL if not uploading directly">
                    <?php $__errorArgs = ['file_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>




                <div class="mb-3">
                    <label for="version_date" class="form-label">Version Date</label>
                    <input type="date" name="version_date" class="form-control" id="version_date"
                        value="<?php echo e(old('version_date', date('Y-m-d'))); ?>">
                    <?php $__errorArgs = ['version_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="version" class="form-label">Version</label>
                    <input type="text" name="version" class="form-control" id="version" value="<?php echo e(old('version')); ?>"
                        placeholder="e.g., 1.0">
                    <?php $__errorArgs = ['version'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" name="size" class="form-control" id="size" value="<?php echo e(old('size')); ?>"
                        placeholder="e.g., 1MB">
                    <?php $__errorArgs = ['size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('blur', function (e) {
            if (e.target.id === 'document_name') required('document_name', 'docNameError');
            if (e.target.id === 'document_type') required('document_type', 'docTypeError');
            if (e.target.id === 'document_category') required('document_category', 'docCategoryError');
            if (e.target.id === 'document_brand') required('document_brand', 'docBrandError');
        }, true);

        function required(id, errorId) {
            const el = document.getElementById(id);
            const err = document.getElementById(errorId);

            if (!el.value.trim()) {
                err.classList.remove('d-none');
                el.classList.add('is-invalid');
                return false;
            } else {
                err.classList.add('d-none');
                el.classList.remove('is-invalid');
                return true;
            }
        }

        // Special case: documents OR file_link
        document.querySelector('form').addEventListener('submit', function (e) {
            const files = document.querySelector('input[name="documents[]"]').files.length;
            const link = document.getElementById('file_link').value.trim();

            if (!files && !link) {
                e.preventDefault();
                document.getElementById('fileError').classList.remove('d-none');
            } else {
                document.getElementById('fileError').classList.add('d-none');
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'Enter your description here...',
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['help']]
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let filters = <?php echo json_encode($filters, 15, 512) ?> || [];
            // Ensure filters is an array
            if (!Array.isArray(filters)) {
                try {
                    filters = Object.values(filters);
                } catch (e) {
                    filters = [];
                }
            }

            const container = document.getElementById('filters-container');
            if (!container) {
                console.error('[filters] container not found');
                return; // nothing to do
            }

            function populateOptionsForSelect(filterSelect, optionSelect) {
                const selectedId = filterSelect.value;
                optionSelect.innerHTML = '<option value="">Select Option</option>';
                if (!selectedId) return;
                const selectedFilter = filters.find(f => String(f.id) === String(selectedId));
                if (!selectedFilter || !selectedFilter.options) return;
                selectedFilter.options.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt.id;
                    o.textContent = opt.name;
                    optionSelect.appendChild(o);
                });
            }

            // Debug helper
            console.debug('populateOptionsForSelect ready, filters sample:', filters && filters.slice ? filters.slice(0, 3) : filters);

            // Attach direct listeners to existing filter-select elements (safe fallback)
            function attachDirectListeners() {
                Array.from(container.querySelectorAll('.filter-pair')).forEach(pair => {
                    const filterSel = pair.querySelector('.filter-select');
                    const optionSel = pair.querySelector('.filter-option-select');
                    const addBtn = pair.querySelector('.btn-add');
                    const remBtn = pair.querySelector('.btn-remove');

                    if (filterSel) {
                        filterSel.addEventListener('change', function (ev) {
                            console.debug('direct change listener fired for filter-select', this.value);
                            populateOptionsForSelect(this, optionSel);
                        });
                    }

                    if (addBtn) {
                        addBtn.addEventListener('click', function () {
                            console.debug('add button clicked (direct)');
                            addFilterPair();
                        });
                    }

                    if (remBtn) {
                        remBtn.addEventListener('click', function () {
                            console.debug('remove button clicked (direct)');
                            // emulate delegated behavior
                            if (container.querySelectorAll('.filter-pair').length > 1) {
                                pair.remove();
                            } else {
                                if (filterSel) filterSel.value = '';
                                if (optionSel) optionSel.innerHTML = '<option value="">Select Option</option>';
                            }
                        });
                    }
                });
            }

            // Using direct listeners attached to existing pairs and new pairs (no delegation)

            function addFilterPair(selectedFilter = '', selectedOption = '') {
                const index = container.querySelectorAll('.filter-pair').length;
                const wrapper = document.createElement('div');
                wrapper.className = 'filter-pair mb-2 d-flex align-items-start';

                const filterSel = document.createElement('select');
                filterSel.name = 'filter_id[]';
                filterSel.className = 'form-control me-2 filter-select';
                filterSel.innerHTML = '<option value="">Select Filter</option>' +
                    filters.map(f => `<option value="${f.id}" ${f.id == selectedFilter ? 'selected' : ''}>${f.name}</option>`).join('');

                const optionSel = document.createElement('select');
                optionSel.name = 'filter_option_id[]';
                optionSel.className = 'form-control me-2 filter-option-select';
                optionSel.innerHTML = '<option value="">Select Option</option>';

                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'btn btn-success btn-add me-1';
                addBtn.textContent = '+';

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger btn-remove';
                removeBtn.textContent = '−';

                wrapper.appendChild(filterSel);
                wrapper.appendChild(optionSel);
                wrapper.appendChild(addBtn);
                wrapper.appendChild(removeBtn);

                container.appendChild(wrapper);

                // attach change listener to newly created select
                filterSel.addEventListener('change', function () {
                    console.debug('change on newly added filter-select', this.value);
                    populateOptionsForSelect(this, optionSel);
                });

                // attach debug click handlers for new buttons
                addBtn.addEventListener('click', function () { console.debug('add button clicked (new)'); addFilterPair(); });
                removeBtn.addEventListener('click', function () {
                    console.debug('remove button clicked (new)');
                    if (container.querySelectorAll('.filter-pair').length > 1) wrapper.remove();
                    else { filterSel.value = ''; optionSel.innerHTML = '<option value="">Select Option</option>'; }
                });

                // If a preselected filter is provided, populate options and set selected option
                if (selectedFilter) {
                    populateOptionsForSelect(filterSel, optionSel);
                    if (selectedOption) {
                        optionSel.value = selectedOption;
                    }
                }
            }

            // Debug info
            console.debug('filters loaded:', filters.length);

            // Ensure existing buttons are set to type=button (safety) and initialize any existing pairs
            Array.from(container.querySelectorAll('.filter-pair')).forEach(pair => {
                const addBtn = pair.querySelector('.btn-add');
                const remBtn = pair.querySelector('.btn-remove');
                if (addBtn) addBtn.type = 'button';
                if (remBtn) remBtn.type = 'button';

                const filterSel = pair.querySelector('.filter-select');
                const optionSel = pair.querySelector('.filter-option-select');
                if (filterSel && filterSel.value) populateOptionsForSelect(filterSel, optionSel);
            });

            // Attach direct listeners (fallback) after initialization
            attachDirectListeners();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2026 -BK\NEXT SOLUTION\FEBRUARY\28-02-2026\next-solutions new\resources\views/admin/documents-sections/create.blade.php ENDPATH**/ ?>