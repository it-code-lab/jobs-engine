<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/LocationService.php';

$states = LocationService::getActiveStates();
$pageTitle = getPageTitle('Guided Discovery');

require_once __DIR__ . '/../app/includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 900px;">
        <h1>Find opportunities that fit your situation</h1>
        <p class="lead">
            Answer a few questions to get practical work and earning recommendations.
        </p>

        <form action="<?= e(buildUrl('recommendation-results.php')) ?>" method="get" class="detail-card" style="margin-top: 24px;">
            <h2>Basic Profile</h2>

            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
                <div>
                    <label>Age Group</label>
                    <select name="age_group" required>
                        <option value="">Select</option>
                        <option value="18_24">18 to 24</option>
                        <option value="25_34">25 to 34</option>
                        <option value="35_44">35 to 44</option>
                        <option value="45_54">45 to 54</option>
                        <option value="55_plus">55+</option>
                    </select>
                </div>

                <div>
                    <label>State</label>
                    <select name="state_id" id="state_id" required>
                        <option value="">Select</option>
                        <?php foreach ($states as $state): ?>
                            <option value="<?= (int)$state['id'] ?>"><?= e($state['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>District / City</label>
                    <select name="district_id" id="district_id" required>
                        <option value="">Select a state first</option>
                    </select>
                </div>
            </div>

            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
                <div>
                    <label>Current Work Status</label>
                    <select name="current_work_status" required>
                        <option value="unemployed">Unemployed</option>
                        <option value="student">Student</option>
                        <option value="homemaker">Homemaker</option>
                        <option value="part_time_worker">Part-Time Worker</option>
                        <option value="full_time_worker">Full-Time Worker</option>
                        <option value="self_employed">Self-Employed</option>
                        <option value="business_owner">Business Owner</option>
                    </select>
                </div>

                <div>
                    <label>Education Level</label>
                    <select name="education_level" required>
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

                <div>
                    <label>Prior Experience</label>
                    <select name="prior_experience_level" required>
                        <option value="none">None</option>
                        <option value="beginner">Beginner</option>
                        <option value="some">Some</option>
                        <option value="experienced">Experienced</option>
                    </select>
                </div>
            </div>

            <h2>Resources and Preferences</h2>

            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
                <div>
                    <label>Available Investment</label>
                    <select name="available_investment_range" required>
                        <option value="none">None</option>
                        <option value="under_5000">Under ₹5,000</option>
                        <option value="5000_20000">₹5,000 - ₹20,000</option>
                        <option value="20000_50000">₹20,000 - ₹50,000</option>
                        <option value="50000_100000">₹50,000 - ₹1,00,000</option>
                        <option value="above_100000">Above ₹1,00,000</option>
                    </select>
                </div>

                <div>
                    <label>Work Preference</label>
                    <select name="work_preference" required>
                        <option value="open_to_all">Open to All</option>
                        <option value="jobs_only">Jobs Only</option>
                        <option value="home_based_only">Home-Based Work Only</option>
                        <option value="self_employment_only">Self-Employment Only</option>
                        <option value="business_only">Business Only</option>
                    </select>
                </div>

                <div>
                    <label>Home-Based Preference</label>
                    <select name="home_based_preference" required>
                        <option value="not_important">Not Important</option>
                        <option value="preferred">Preferred</option>
                        <option value="required">Required</option>
                    </select>
                </div>
            </div>

            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
                <div>
                    <label>Need Income Urgently?</label>
                    <select name="urgent_income_need" required>
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>

                <div>
                    <label>Digital Literacy</label>
                    <select name="digital_literacy_level" required>
                        <option value="none">None</option>
                        <option value="basic">Basic</option>
                        <option value="moderate">Moderate</option>
                        <option value="strong">Strong</option>
                    </select>
                </div>

                <div>
                    <label>Manual Work Acceptance</label>
                    <select name="manual_work_acceptance" required>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>

            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:16px;">
                <div>
                    <label>Risk Tolerance</label>
                    <select name="risk_tolerance" required>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div>
                    <label>Dependents Count</label>
                    <input type="number" name="dependents_count" min="0" value="0">
                </div>

                <div>
                    <label>Work Hour Limitations</label>
                    <select name="work_hour_limitations" required>
                        <option value="flexible">Flexible</option>
                        <option value="moderate">Moderate</option>
                        <option value="strict">Strict</option>
                    </select>
                </div>
            </div>

            <h2>Available Resources</h2>

            <div class="form-row" style="grid-template-columns: repeat(3, 1fr); margin-bottom:16px;">
                <label><input type="checkbox" name="has_land" value="1"> Land</label>
                <label><input type="checkbox" name="has_shop_space" value="1"> Shop Space</label>
                <label><input type="checkbox" name="has_home_work_space" value="1"> Home Work Space</label>
                <label><input type="checkbox" name="has_smartphone" value="1"> Smartphone</label>
                <label><input type="checkbox" name="has_computer" value="1"> Computer</label>
                <label><input type="checkbox" name="has_internet" value="1"> Internet</label>
               