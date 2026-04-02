<?php
declare(strict_types=1);

$formData = $_POST ?: ($item ?? []);

function fieldValue(array $formData, string $key, $default = '')
{
    return $formData[$key] ?? $default;
}

$steps = $formData['steps'] ?? ($item['steps'] ?? [
    ['step_title' => '', 'step_description' => ''],
    ['step_title' => '', 'step_description' => ''],
    ['step_title' => '', 'step_description' => ''],
]);

$risks = $formData['risks'] ?? ($item['risks'] ?? [
    ['risk_title' => '', 'risk_description' => ''],
    ['risk_title' => '', 'risk_description' => ''],
    ['risk_title' => '', 'risk_description' => ''],
]);

$educationOptions = ['none','primary','middle','secondary','higher_secondary','vocational','diploma','graduate','postgraduate'];
?>

<form method="post" class="detail-card" style="margin-top:20px;">

    <h2 style="margin-bottom:16px;">Basic Information</h2>

    <div class="form-row" style="grid-template-columns: 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Title</label>
            <input type="text" name="title" required value="<?= e(fieldValue($formData, 'title')) ?>">
        </div>
        <div>
            <label>Slug</label>
            <input type="text" name="slug" value="<?= e(fieldValue($formData, 'slug')) ?>">
        </div>
    </div>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int)$cat['id'] ?>" <?= (string)fieldValue($formData, 'category_id') === (string)$cat['id'] ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Opportunity Type</label>
            <select name="opportunity_type" required>
                <?php foreach (['job','home_based_work','self_employment','micro_business'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'opportunity_type') === $v ? 'selected' : '' ?>>
                        <?= e(formatOpportunityType($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Status</label>
            <select name="status" required>
                <?php foreach (['draft','published','archived'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'status', 'draft') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:16px;">
        <label>Short Summary</label>
        <textarea name="short_summary" rows="3" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'short_summary')) ?></textarea>
    </div>

    <div style="margin-bottom:24px;">
        <label>Full Description</label>
        <textarea name="full_description" rows="6" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'full_description')) ?></textarea>
    </div>

    <h2 style="margin:24px 0 16px;">Quick Facts</h2>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Investment Min</label>
            <input type="number" step="0.01" name="investment_min" value="<?= e((string)fieldValue($formData, 'investment_min', '0')) ?>">
        </div>
        <div>
            <label>Investment Max</label>
            <input type="number" step="0.01" name="investment_max" value="<?= e((string)fieldValue($formData, 'investment_max', '0')) ?>">
        </div>
        <div>
            <label>Earning Min</label>
            <input type="number" step="0.01" name="earning_min" value="<?= e((string)fieldValue($formData, 'earning_min')) ?>">
        </div>
        <div>
            <label>Earning Max</label>
            <input type="number" step="0.01" name="earning_max" value="<?= e((string)fieldValue($formData, 'earning_max')) ?>">
        </div>
    </div>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr; margin-bottom:24px;">
        <div>
            <label>Time to Start</label>
            <select name="time_to_start_label">
                <?php foreach (['immediate','within_1_week','within_1_month','more_than_1_month'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'time_to_start_label', 'within_1_month') === $v ? 'selected' : '' ?>>
                        <?= e(str_replace('_', ' ', $v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Home-Based Suitability</label>
            <select name="home_based_suitability">
                <?php foreach (['yes','partial','no'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'home_based_suitability', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Risk Level</label>
            <select name="risk_level">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'risk_level', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Growth Potential</label>
            <select name="growth_potential">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'growth_potential', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Featured</label>
            <select name="featured_flag">
                <option value="0" <?= (string)fieldValue($formData, 'featured_flag', '0') === '0' ? 'selected' : '' ?>>No</option>
                <option value="1" <?= (string)fieldValue($formData, 'featured_flag', '0') === '1' ? 'selected' : '' ?>>Yes</option>
            </select>
        </div>
    </div>

    <h2 style="margin:24px 0 16px;">Requirements</h2>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Min Age</label>
            <input type="number" name="min_age" value="<?= e((string)fieldValue($formData, 'min_age')) ?>">
        </div>
        <div>
            <label>Max Age</label>
            <input type="number" name="max_age" value="<?= e((string)fieldValue($formData, 'max_age')) ?>">
        </div>
        <div>
            <label>Min Education</label>
            <select name="min_education_level">
                <?php foreach ($educationOptions as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'min_education_level', 'none') === $v ? 'selected' : '' ?>>
                        <?= e($v) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Preferred Education</label>
            <select name="preferred_education_level">
                <option value="">Select</option>
                <?php foreach ($educationOptions as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'preferred_education_level') === $v ? 'selected' : '' ?>>
                        <?= e($v) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Prior Experience</label>
            <select name="prior_experience_required">
                <?php foreach (['no','preferred','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'prior_experience_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Digital Literacy</label>
            <select name="digital_literacy_level">
                <?php foreach (['none','basic','moderate','strong'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'digital_literacy_level', 'none') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Manual Effort</label>
            <select name="manual_effort_level">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'manual_effort_level', 'low') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Physical Effort</label>
            <select name="physical_effort_level">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'physical_effort_level', 'low') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Land Required</label>
            <select name="land_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'land_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Shop Space Required</label>
            <select name="shop_space_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'shop_space_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Internet Required</label>
            <select name="internet_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'internet_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Computer Required</label>
            <select name="computer_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'computer_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Smartphone Required</label>
            <select name="smartphone_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'smartphone_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Vehicle Required</label>
            <select name="vehicle_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'vehicle_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Tools Required</label>
            <select name="tools_required">
                <?php foreach (['no','helpful','required'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'tools_required', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Family Support Helpful</label>
            <select name="family_support_helpful">
                <?php foreach (['no','yes'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'family_support_helpful', 'no') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:24px;">
        <label>Tools Required Details</label>
        <textarea name="tools_required_text" rows="2" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'tools_required_text')) ?></textarea>
    </div>

    <h2 style="margin:24px 0 16px;">Suitability</h2>

    <div style="margin-bottom:16px;">
        <label>Suitable For</label>
        <textarea name="suitable_for_text" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'suitable_for_text')) ?></textarea>
    </div>

    <div style="margin-bottom:24px;">
        <label>Not Suitable For</label>
        <textarea name="not_suitable_for_text" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'not_suitable_for_text')) ?></textarea>
    </div>

    <h2 style="margin:24px 0 16px;">Market and Location Fit</h2>

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Scalability Level</label>
            <select name="scalability_level">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'scalability_level', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Urban Suitability</label>
            <select name="urban_suitability">
                <?php foreach (['high','medium','low'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'urban_suitability', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Semi-Urban Suitability</label>
            <select name="semi_urban_suitability">
                <?php foreach (['high','medium','low'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'semi_urban_suitability', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Rural Suitability</label>
            <select name="rural_suitability">
                <?php foreach (['high','medium','low'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'rural_suitability', 'medium') === $v ? 'selected' : '' ?>>
                        <?= e(ucfirst($v)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:16px;">
        <label>Market Dependency Notes</label>
        <textarea name="market_dependency_notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'market_dependency_notes')) ?></textarea>
    </div>

    <div style="margin-bottom:24px;">
        <label>Raw Material Dependency Notes</label>
        <textarea name="raw_material_dependency_notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'raw_material_dependency_notes')) ?></textarea>
    </div>

    <h2 style="margin:24px 0 16px;">Practical Guidance</h2>

    <div style="margin-bottom:16px;">
        <label>First Income Timeline</label>
        <input type="text" name="first_income_timeline" value="<?= e(fieldValue($formData, 'first_income_timeline')) ?>">
    </div>

    <div style="margin-bottom:16px;">
        <label>Success Tips</label>
        <textarea name="success_tips" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'success_tips')) ?></textarea>
    </div>

    <div style="margin-bottom:24px;">
        <label>Common Mistakes</label>
        <textarea name="common_mistakes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'common_mistakes')) ?></textarea>
    </div>

    <h2 style="margin:24px 0 16px;">First Steps</h2>
    <p style="margin:-6px 0 16px; color:#64748b;">Add practical steps users can follow to get started.</p>

    <div id="steps-wrapper">
        <?php foreach ($steps as $i => $step): ?>
            <div class="detail-card step-row" style="margin-bottom:12px; padding:16px;" data-index="<?= $i ?>">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <strong>Step <span class="step-number"><?= $i + 1 ?></span></strong>
                    <button type="button" class="btn btn-secondary remove-step-btn">Remove</button>
                </div>

                <div style="margin-bottom:10px;">
                    <label>Step Title</label>
                    <input type="text" name="steps[<?= $i ?>][step_title]" value="<?= e($step['step_title'] ?? '') ?>">
                </div>
                <div>
                    <label>Step Description</label>
                    <textarea name="steps[<?= $i ?>][step_description]" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e($step['step_description'] ?? '') ?></textarea>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-bottom:24px;">
        <button type="button" class="btn btn-primary" id="add-step-btn">Add First Step</button>
    </div>

    <h2 style="margin:24px 0 16px;">Risks and Challenges</h2>
    <p style="margin:-6px 0 16px; color:#64748b;">Add realistic risks so users can make better decisions.</p>

    <div id="risks-wrapper">
        <?php foreach ($risks as $i => $risk): ?>
            <div class="detail-card risk-row" style="margin-bottom:12px; padding:16px;" data-index="<?= $i ?>">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <strong>Risk <span class="risk-number"><?= $i + 1 ?></span></strong>
                    <button type="button" class="btn btn-secondary remove-risk-btn">Remove</button>
                </div>

                <div style="margin-bottom:10px;">
                    <label>Risk Title</label>
                    <input type="text" name="risks[<?= $i ?>][risk_title]" value="<?= e($risk['risk_title'] ?? '') ?>">
                </div>
                <div>
                    <label>Risk Description</label>
                    <textarea name="risks[<?= $i ?>][risk_description]" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e($risk['risk_description'] ?? '') ?></textarea>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-bottom:24px;">
        <button type="button" class="btn btn-primary" id="add-risk-btn">Add Risk</button>
    </div>

    <button class="btn btn-primary" type="submit">Save Opportunity</button>
<template id="step-template">
    <div class="detail-card step-row" style="margin-bottom:12px; padding:16px;" data-index="__INDEX__">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <strong>Step <span class="step-number">__NUMBER__</span></strong>
            <button type="button" class="btn btn-secondary remove-step-btn">Remove</button>
        </div>

        <div style="margin-bottom:10px;">
            <label>Step Title</label>
            <input type="text" name="steps[__INDEX__][step_title]" value="">
        </div>
        <div>
            <label>Step Description</label>
            <textarea name="steps[__INDEX__][step_description]" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"></textarea>
        </div>
    </div>
</template>

<template id="risk-template">
    <div class="detail-card risk-row" style="margin-bottom:12px; padding:16px;" data-index="__INDEX__">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <strong>Risk <span class="risk-number">__NUMBER__</span></strong>
            <button type="button" class="btn btn-secondary remove-risk-btn">Remove</button>
        </div>

        <div style="margin-bottom:10px;">
            <label>Risk Title</label>
            <input type="text" name="risks[__INDEX__][risk_title]" value="">
        </div>
        <div>
            <label>Risk Description</label>
            <textarea name="risks[__INDEX__][risk_description]" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"></textarea>
        </div>
    </div>
</template>

<script>
(function () {
    const stepsWrapper = document.getElementById('steps-wrapper');
    const risksWrapper = document.getElementById('risks-wrapper');
    const addStepBtn = document.getElementById('add-step-btn');
    const addRiskBtn = document.getElementById('add-risk-btn');
    const stepTemplate = document.getElementById('step-template').innerHTML;
    const riskTemplate = document.getElementById('risk-template').innerHTML;

    function renumberSteps() {
        const rows = stepsWrapper.querySelectorAll('.step-row');
        rows.forEach((row, index) => {
            row.dataset.index = index;
            const numberEl = row.querySelector('.step-number');
            if (numberEl) numberEl.textContent = index + 1;

            const titleInput = row.querySelector('input[name*="[step_title]"]');
            const descInput = row.querySelector('textarea[name*="[step_description]"]');

            if (titleInput) titleInput.name = `steps[${index}][step_title]`;
            if (descInput) descInput.name = `steps[${index}][step_description]`;
        });
    }

    function renumberRisks() {
        const rows = risksWrapper.querySelectorAll('.risk-row');
        rows.forEach((row, index) => {
            row.dataset.index = index;
            const numberEl = row.querySelector('.risk-number');
            if (numberEl) numberEl.textContent = index + 1;

            const titleInput = row.querySelector('input[name*="[risk_title]"]');
            const descInput = row.querySelector('textarea[name*="[risk_description]"]');

            if (titleInput) titleInput.name = `risks[${index}][risk_title]`;
            if (descInput) descInput.name = `risks[${index}][risk_description]`;
        });
    }

    addStepBtn.addEventListener('click', function () {
        const index = stepsWrapper.querySelectorAll('.step-row').length;
        const html = stepTemplate
            .replaceAll('__INDEX__', index)
            .replaceAll('__NUMBER__', index + 1);
        stepsWrapper.insertAdjacentHTML('beforeend', html);
        renumberSteps();
    });

    addRiskBtn.addEventListener('click', function () {
        const index = risksWrapper.querySelectorAll('.risk-row').length;
        const html = riskTemplate
            .replaceAll('__INDEX__', index)
            .replaceAll('__NUMBER__', index + 1);
        risksWrapper.insertAdjacentHTML('beforeend', html);
        renumberRisks();
    });

    stepsWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-step-btn')) {
            const rows = stepsWrapper.querySelectorAll('.step-row');
            if (rows.length <= 1) {
                alert('At least one step block should remain visible.');
                return;
            }
            e.target.closest('.step-row').remove();
            renumberSteps();
        }
    });

    risksWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-risk-btn')) {
            const rows = risksWrapper.querySelectorAll('.risk-row');
            if (rows.length <= 1) {
                alert('At least one risk block should remain visible.');
                return;
            }
            e.target.closest('.risk-row').remove();
            renumberRisks();
        }
    });

    renumberSteps();
    renumberRisks();
})();
</script>    
</form>