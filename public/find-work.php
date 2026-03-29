<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/includes/db.php';

$pageTitle = getPageTitle('Find Suitable Work');

$pdo = db();
$statesStmt = $pdo->query("SELECT id, name FROM jobs_states WHERE status = 'active' ORDER BY sort_order ASC, name ASC");
$states = $statesStmt->fetchAll();

require_once __DIR__ . '/../app/includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 950px;">
        <div class="detail-card">
            <h1>Find Suitable Work</h1>
            <p class="lead">
                Answer a few questions and we will show work and earning opportunities
                that may fit your situation.
            </p>

            <form method="get" action="<?= e(buildUrl('recommendation-results.php')) ?>">
                <h3 style="margin-top: 24px;">Basic Profile</h3>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>Age Group</label>
                        <select name="age_group" required>
                            <option value="">Select</option>
                            <option value="18_24">18–24</option>
                            <option value="25_34">25–34</option>
                            <option value="35_44">35–44</option>
                            <option value="45_54">45–54</option>
                            <option value="55_plus">55+</option>
                        </select>
                    </div>

                    <div>
                        <label>Current Work Status</label>
                        <select name="current_work_status" required>
                            <option value="">Select</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="student">Student</option>
                            <option value="homemaker">Homemaker</option>
                            <option value="part_time_worker">Part-time Worker</option>
                            <option value="full_time_worker">Full-time Worker</option>
                            <option value="self_employed">Self-Employed</option>
                            <option value="business_owner">Business Owner</option>
                        </select>
                    </div>

                    <div>
                        <label>Education Level</label>
                        <select name="education_level" required>
                            <option value="">Select</option>
                            <option value="none">None</option>
                            <option value="primary">Primary</option>
                            <option value="middle">Middle</option>
                            <option value="secondary">Secondary</option>
                            <option value="higher_secondary">Higher Secondary</option>
                            <option value="vocational">Vocational</option>
                            <option value="diploma">Diploma</option>
                            <option value="graduate">Graduate</option>
                            <option value="postgraduate">Postgraduate</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>State</label>
                        <select name="state_id" id="state_id" required>
                            <option value="">Select State</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?= (int)$state['id'] ?>"><?= e($state['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label>District / City</label>
                        <select name="district_id" id="district_id" required>
                            <option value="">Select District / City</option>
                        </select>
                    </div>

                    <div>
                        <label>Available Investment</label>
                        <select name="available_investment_range" required>
                            <option value="">Select</option>
                            <option value="none">None</option>
                            <option value="under_5000">Under ₹5,000</option>
                            <option value="5000_20000">₹5,000 – ₹20,000</option>
                            <option value="20000_50000">₹20,000 – ₹50,000</option>
                            <option value="50000_100000">₹50,000 – ₹1,00,000</option>
                            <option value="above_100000">Above ₹1,00,000</option>
                        </select>
                    </div>
                </div>

                <h3 style="margin-top: 24px;">Work Preferences</h3>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>Work Preference</label>
                        <select name="work_preference" required>
                            <option value="">Select</option>
                            <option value="jobs_only">Jobs Only</option>
                            <option value="home_based_only">Home-Based Only</option>
                            <option value="self_employment_only">Self-Employment Only</option>
                            <option value="business_only">Business Only</option>
                            <option value="open_to_all">Open to All</option>
                        </select>
                    </div>

                    <div>
                        <label>Home-Based Preference</label>
                        <select name="home_based_preference" required>
                            <option value="">Select</option>
                            <option value="required">Required</option>
                            <option value="preferred">Preferred</option>
                            <option value="not_important">Not Important</option>
                        </select>
                    </div>

                    <div>
                        <label>Need Income Urgently?</label>
                        <select name="urgent_income_need" required>
                            <option value="">Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>Digital Literacy</label>
                        <select name="digital_literacy_level" required>
                            <option value="">Select</option>
                            <option value="none">None</option>
                            <option value="basic">Basic</option>
                            <option value="moderate">Moderate</option>
                            <option value="strong">Strong</option>
                        </select>
                    </div>

                    <div>
                        <label>Manual Work Acceptance</label>
                        <select name="manual_work_acceptance" required>
                            <option value="">Select</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div>
                        <label>Risk Tolerance</label>
                        <select name="risk_tolerance" required>
                            <option value="">Select</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>

                <h3 style="margin-top: 24px;">Resources</h3>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>Have Land?</label>
                        <select name="has_land" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Have Shop / Work Space?</label>
                        <select name="has_shop_space" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Have Smartphone?</label>
                        <select name="has_smartphone" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Have Internet?</label>
                        <select name="has_internet" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr 1fr; margin-bottom: 16px;">
                    <div>
                        <label>Have Computer?</label>
                        <select name="has_computer" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Have Vehicle?</label>
                        <select name="has_vehicle" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Have Tools / Equipment?</label>
                        <select name="has_tools_equipment" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div>
                        <label>Family Support Available?</label>
                        <select name="family_support_available" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Show My Matches</button>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');

    stateSelect.addEventListener('change', function () {
        const stateId = this.value;
        districtSelect.innerHTML = '<option value="">Loading...</option>';

        if (!stateId) {
            districtSelect.innerHTML = '<option value="">Select District / City</option>';
            return;
        }

        fetch('<?= e(buildUrl('api-districts.php')) ?>?state_id=' + encodeURIComponent(stateId))
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Select District / City</option>';

                if (Array.isArray(data)) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        districtSelect.appendChild(option);
                    });
                }
            })
            .catch(() => {
                districtSelect.innerHTML = '<option value="">Unable to load districts</option>';
            });
    });
});
</script>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>