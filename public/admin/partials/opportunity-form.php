<?php
declare(strict_types=1);

$formData = $_POST ?: ($item ?? []);

function fieldValue(array $formData, string $key, $default = '') {
    return $formData[$key] ?? $default;
}
?>

<form method="post" class="detail-card" style="margin-top:20px;">
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
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'opportunity_type') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Status</label>
            <select name="status" required>
                <?php foreach (['draft','published','archived'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'status', 'draft') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:16px;">
        <label>Short Summary</label>
        <textarea name="short_summary" rows="3" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'short_summary')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Full Description</label>
        <textarea name="full_description" rows="6" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'full_description')) ?></textarea>
    </div>

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
                <?php foreach (['none','primary','middle','secondary','higher_secondary','vocational','diploma','graduate','postgraduate'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'min_education_level', 'none') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Preferred Education</label>
            <select name="preferred_education_level">
                <option value="">Select</option>
                <?php foreach (['none','primary','middle','secondary','higher_secondary','vocational','diploma','graduate','postgraduate'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'preferred_education_level') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

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

    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom:16px;">
        <div>
            <label>Home-Based Suitability</label>
            <select name="home_based_suitability">
                <?php foreach (['yes','partial','no'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'home_based_suitability', 'no') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Risk Level</label>
            <select name="risk_level">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'risk_level', 'medium') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Growth Potential</label>
            <select name="growth_potential">
                <?php foreach (['low','medium','high'] as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, 'growth_potential', 'medium') === $v ? 'selected' : '' ?>><?= e($v) ?></option>
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

    <div style="margin-bottom:16px;">
        <label>Suitable For</label>
        <textarea name="suitable_for_text" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'suitable_for_text')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Not Suitable For</label>
        <textarea name="not_suitable_for_text" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'not_suitable_for_text')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Success Tips</label>
        <textarea name="success_tips" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'success_tips')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Common Mistakes</label>
        <textarea name="common_mistakes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'common_mistakes')) ?></textarea>
    </div>

    <?php
    $defaults = [
        'prior_experience_required' => 'no',
        'digital_literacy_level' => 'none',
        'manual_effort_level' => 'low',
        'time_to_start_label' => 'within_1_month',
        'land_required' => 'no',
        'shop_space_required' => 'no',
        'internet_required' => 'no',
        'computer_required' => 'no',
        'smartphone_required' => 'no',
        'vehicle_required' => 'no',
        'tools_required' => 'no',
        'family_support_helpful' => 'no',
        'physical_effort_level' => 'low',
        'scalability_level' => 'medium',
        'urban_suitability' => 'medium',
        'semi_urban_suitability' => 'medium',
        'rural_suitability' => 'medium',
    ];
    foreach ($defaults as $name => $default):
        $options = match ($name) {
            'prior_experience_required' => ['no','preferred','required'],
            'digital_literacy_level' => ['none','basic','moderate','strong'],
            'manual_effort_level', 'physical_effort_level' => ['low','medium','high'],
            'time_to_start_label' => ['immediate','within_1_week','within_1_month','more_than_1_month'],
            'land_required','shop_space_required','internet_required','computer_required','smartphone_required','vehicle_required','tools_required' => ['no','helpful','required'],
            'family_support_helpful' => ['no','yes'],
            'scalability_level' => ['low','medium','high'],
            'urban_suitability','semi_urban_suitability','rural_suitability' => ['high','medium','low'],
            default => [],
        };
    ?>
        <div style="margin-bottom:16px;">
            <label><?= e(ucwords(str_replace('_', ' ', $name))) ?></label>
            <select name="<?= e($name) ?>">
                <?php foreach ($options as $v): ?>
                    <option value="<?= e($v) ?>" <?= fieldValue($formData, $name, $default) === $v ? 'selected' : '' ?>><?= e($v) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>

    <div style="margin-bottom:16px;">
        <label>Tools Required Text</label>
        <textarea name="tools_required_text" rows="2" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'tools_required_text')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Market Dependency Notes</label>
        <textarea name="market_dependency_notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'market_dependency_notes')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>Raw Material Dependency Notes</label>
        <textarea name="raw_material_dependency_notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:10px;"><?= e(fieldValue($formData, 'raw_material_dependency_notes')) ?></textarea>
    </div>

    <div style="margin-bottom:16px;">
        <label>First Income Timeline</label>
        <input type="text" name="first_income_timeline" value="<?= e(fieldValue($formData, 'first_income_timeline')) ?>">
    </div>

    <button class="btn btn-primary" type="submit">Save Opportunity</button>
</form>