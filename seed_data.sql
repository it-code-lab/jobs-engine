-- =========================================================
-- Career and Livelihood Guidance Platform - India V1
-- Starter Seed Data
-- =========================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------
-- ADMIN USER
-- Replace password_hash with a real PHP password_hash() output
-- ---------------------------------------------------------
INSERT INTO jobs_admin_users (full_name, email, password_hash, role, status)
VALUES
('Super Admin', 'admin@example.com', '$2y$10$replace_with_real_password_hash_here', 'admin', 'active');

-- ---------------------------------------------------------
-- OPPORTUNITY CATEGORIES
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_categories (name, slug, description, sort_order, status)
VALUES
('Jobs', 'jobs', 'Employment jobs_opportunities suitable for different backgrounds and locations.', 1, 'active'),
('Home-Based Work', 'home-based-work', 'Income jobs_opportunities that can be started or operated from home.', 2, 'active'),
('Self-Employment', 'self-employment', 'Independent service-based or skill-based work jobs_opportunities.', 3, 'active'),
('Micro-Business', 'micro-business', 'Small business ideas with low to moderate startup investment.', 4, 'active');

-- ---------------------------------------------------------
-- STATES / UNION TERRITORIES
-- ---------------------------------------------------------
INSERT INTO jobs_states (name, slug, code, sort_order, status) VALUES
('Andhra Pradesh', 'andhra-pradesh', 'AP', 1, 'active'),
('Arunachal Pradesh', 'arunachal-pradesh', 'AR', 2, 'active'),
('Assam', 'assam', 'AS', 3, 'active'),
('Bihar', 'bihar', 'BR', 4, 'active'),
('Chhattisgarh', 'chhattisgarh', 'CG', 5, 'active'),
('Goa', 'goa', 'GA', 6, 'active'),
('Gujarat', 'gujarat', 'GJ', 7, 'active'),
('Haryana', 'haryana', 'HR', 8, 'active'),
('Himachal Pradesh', 'himachal-pradesh', 'HP', 9, 'active'),
('Jharkhand', 'jharkhand', 'JH', 10, 'active'),
('Karnataka', 'karnataka', 'KA', 11, 'active'),
('Kerala', 'kerala', 'KL', 12, 'active'),
('Madhya Pradesh', 'madhya-pradesh', 'MP', 13, 'active'),
('Maharashtra', 'maharashtra', 'MH', 14, 'active'),
('Manipur', 'manipur', 'MN', 15, 'active'),
('Meghalaya', 'meghalaya', 'ML', 16, 'active'),
('Mizoram', 'mizoram', 'MZ', 17, 'active'),
('Nagaland', 'nagaland', 'NL', 18, 'active'),
('Odisha', 'odisha', 'OD', 19, 'active'),
('Punjab', 'punjab', 'PB', 20, 'active'),
('Rajasthan', 'rajasthan', 'RJ', 21, 'active'),
('Sikkim', 'sikkim', 'SK', 22, 'active'),
('Tamil Nadu', 'tamil-nadu', 'TN', 23, 'active'),
('Telangana', 'telangana', 'TS', 24, 'active'),
('Tripura', 'tripura', 'TR', 25, 'active'),
('Uttar Pradesh', 'uttar-pradesh', 'UP', 26, 'active'),
('Uttarakhand', 'uttarakhand', 'UK', 27, 'active'),
('West Bengal', 'west-bengal', 'WB', 28, 'active'),
('Andaman and Nicobar Islands', 'andaman-and-nicobar-islands', 'AN', 29, 'active'),
('Chandigarh', 'chandigarh', 'CH', 30, 'active'),
('Dadra and Nagar Haveli and Daman and Diu', 'dadra-and-nagar-haveli-and-daman-and-diu', 'DN', 31, 'active'),
('Delhi', 'delhi', 'DL', 32, 'active'),
('Jammu and Kashmir', 'jammu-and-kashmir', 'JK', 33, 'active'),
('Ladakh', 'ladakh', 'LA', 34, 'active'),
('Lakshadweep', 'lakshadweep', 'LD', 35, 'active'),
('Puducherry', 'puducherry', 'PY', 36, 'active');

-- ---------------------------------------------------------
-- STARTER jobs_districts / CITIES
-- Add more over time
-- ---------------------------------------------------------
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Lucknow', 'lucknow', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'uttar-pradesh';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Kanpur Nagar', 'kanpur-nagar', 'urban', 2, 'active' FROM jobs_states WHERE slug = 'uttar-pradesh';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Varanasi', 'varanasi', 'mixed', 3, 'active' FROM jobs_states WHERE slug = 'uttar-pradesh';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Bareilly', 'bareilly', 'mixed', 4, 'active' FROM jobs_states WHERE slug = 'uttar-pradesh';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Noida', 'noida', 'urban', 5, 'active' FROM jobs_states WHERE slug = 'uttar-pradesh';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'New Delhi', 'new-delhi', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'delhi';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Mumbai', 'mumbai', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'maharashtra';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Pune', 'pune', 'urban', 2, 'active' FROM jobs_states WHERE slug = 'maharashtra';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Nagpur', 'nagpur', 'mixed', 3, 'active' FROM jobs_states WHERE slug = 'maharashtra';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Bengaluru Urban', 'bengaluru-urban', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'karnataka';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Mysuru', 'mysuru', 'mixed', 2, 'active' FROM jobs_states WHERE slug = 'karnataka';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Ahmedabad', 'ahmedabad', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'gujarat';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Surat', 'surat', 'urban', 2, 'active' FROM jobs_states WHERE slug = 'gujarat';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Rajkot', 'rajkot', 'mixed', 3, 'active' FROM jobs_states WHERE slug = 'gujarat';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Jaipur', 'jaipur', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'rajasthan';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Kota', 'kota', 'mixed', 2, 'active' FROM jobs_states WHERE slug = 'rajasthan';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Indore', 'indore', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'madhya-pradesh';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Bhopal', 'bhopal', 'urban', 2, 'active' FROM jobs_states WHERE slug = 'madhya-pradesh';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Patna', 'patna', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'bihar';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Gaya', 'gaya', 'mixed', 2, 'active' FROM jobs_states WHERE slug = 'bihar';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Kolkata', 'kolkata', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'west-bengal';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Siliguri', 'siliguri', 'mixed', 2, 'active' FROM jobs_states WHERE slug = 'west-bengal';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Chennai', 'chennai', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'tamil-nadu';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Coimbatore', 'coimbatore', 'urban', 2, 'active' FROM jobs_states WHERE slug = 'tamil-nadu';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Hyderabad', 'hyderabad', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'telangana';
INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Warangal', 'warangal', 'mixed', 2, 'active' FROM jobs_states WHERE slug = 'telangana';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Bhubaneswar', 'bhubaneswar', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'odisha';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Ludhiana', 'ludhiana', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'punjab';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Gurugram', 'gurugram', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'haryana';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Dehradun', 'dehradun', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'uttarakhand';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Kochi', 'kochi', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'kerala';

INSERT INTO jobs_districts (state_id, name, slug, district_type, sort_order, status)
SELECT id, 'Guwahati', 'guwahati', 'urban', 1, 'active' FROM jobs_states WHERE slug = 'assam';

-- ---------------------------------------------------------
-- DISTRICT CONTEXT TAGS
-- ---------------------------------------------------------
INSERT INTO jobs_district_context_tags (district_id, context_tag)
SELECT id, 'service_economy' FROM jobs_districts WHERE slug IN ('new-delhi', 'mumbai', 'pune', 'bengaluru-urban', 'gurugram', 'noida');

INSERT INTO jobs_district_context_tags (district_id, context_tag)
SELECT id, 'industrial' FROM jobs_districts WHERE slug IN ('surat', 'ahmedabad', 'nagpur', 'kanpur-nagar');

INSERT INTO jobs_district_context_tags (district_id, context_tag)
SELECT id, 'education_hub' FROM jobs_districts WHERE slug IN ('kota', 'varanasi', 'pune', 'bengaluru-urban');

INSERT INTO jobs_district_context_tags (district_id, context_tag)
SELECT id, 'agriculture_dominant' FROM jobs_districts WHERE slug IN ('bareilly', 'gaya', 'warangal');

INSERT INTO jobs_district_context_tags (district_id, context_tag)
SELECT id, 'tourist' FROM jobs_districts WHERE slug IN ('jaipur', 'kochi', 'mysuru', 'varanasi', 'dehradun');

-- ---------------------------------------------------------
-- SCORING WEIGHTS
-- ---------------------------------------------------------
INSERT INTO jobs_scoring_weights (rule_key, weight_value, status)
VALUES
('age_match', 8.00, 'active'),
('education_match', 10.00, 'active'),
('work_preference_match', 10.00, 'active'),
('investment_match', 15.00, 'active'),
('location_match', 15.00, 'active'),
('home_based_match', 10.00, 'active'),
('resource_match', 12.00, 'active'),
('urgent_income_match', 8.00, 'active'),
('experience_match', 5.00, 'active'),
('digital_manual_match', 3.00, 'active'),
('family_fit_match', 2.00, 'active'),
('risk_match', 2.00, 'active');

-- ---------------------------------------------------------
-- TAGS
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_tags (name, slug, status)
VALUES
('Low Investment', 'low-investment', 'active'),
('For Homemakers', 'for-homemakers', 'active'),
('Quick Income', 'quick-income', 'active'),
('Beginner Friendly', 'beginner-friendly', 'active'),
('Rural Friendly', 'rural-friendly', 'active'),
('Urban Friendly', 'urban-friendly', 'active'),
('From Home', 'from-home', 'active'),
('Part Time', 'part-time', 'active');

-- ---------------------------------------------------------
-- SAMPLE jobs_opportunities
-- ---------------------------------------------------------

-- 1. Retail Store Assistant
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Retail Store Assistant', 'retail-store-assistant',
    'Entry-level retail role suitable for urban and semi-urban locations.',
    'Retail store assistants support day-to-day store operations, help customers, manage shelves, assist with billing, and maintain store cleanliness and display.',
    'job',
    'Suitable for unemployed adults and youth looking for quick-entry work in cities and towns.',
    'Not ideal for users who require strictly home-based work or cannot stand for long hours.',
    18, 45, 'secondary', 'higher_secondary',
    'no', 'basic', 'medium', 'no',
    0, 0, 10000, 18000, 'within_1_week', 'medium',
    'no', 'no', 'helpful', 'no', 'helpful',
    'no', 'no', NULL, 'no', 'medium',
    'low', 'low', 'high', 'high', 'medium',
    'Depends on local retail demand and store density.', NULL, 'Usually within 1 to 3 weeks',
    'Good communication and punctuality improve hiring chances.',
    'Poor customer behavior and irregular attendance reduce success.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'jobs';

-- 2. Delivery Rider / Delivery Partner
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Delivery Partner', 'delivery-partner',
    'Fast-start earning option for users with a two-wheeler and smartphone.',
    'Delivery partners work with food, grocery, e-commerce, or courier platforms to deliver orders locally and earn through trips and incentives.',
    'self_employment',
    'Suitable for users needing urgent income and who can travel locally.',
    'Not ideal for users without travel ability or without access to a vehicle.',
    18, 50, 'secondary', 'higher_secondary',
    'no', 'basic', 'medium', 'no',
    1000, 5000, 12000, 30000, 'immediate', 'medium',
    'no', 'no', 'required', 'no', 'required',
    'required', 'helpful', 'Basic bag or phone holder can help.', 'no', 'medium',
    'medium', 'medium', 'high', 'high', 'low',
    'Depends on platform availability and order density in the area.', NULL, 'Often within a few days',
    'Choosing good time slots and high-demand areas improves earnings.',
    'Ignoring fuel costs and vehicle maintenance can reduce net income.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'self-employment';

-- 3. Data Entry / Office Support Assistant
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Data Entry / Office Support Assistant', 'data-entry-office-support-assistant',
    'Entry-level office work suitable for users with basic computer skills.',
    'This role involves entering data, organizing files, basic documentation, handling office records, and supporting administrative work.',
    'job',
    'Suitable for educated youth and unemployed adults in urban and semi-urban jobs_districts.',
    'Not suitable for users without basic computer skills or those wanting only home-based work.',
    18, 45, 'higher_secondary', 'graduate',
    'preferred', 'moderate', 'low', 'partial',
    0, 0, 12000, 22000, 'within_1_month', 'medium',
    'no', 'no', 'helpful', 'required', 'helpful',
    'no', 'no', NULL, 'no', 'low',
    'low', 'medium', 'high', 'medium', 'low',
    'Stronger demand in office and service-economy jobs_districts.', NULL, 'Usually within 2 to 6 weeks',
    'Typing speed and spreadsheet familiarity improve jobs_opportunities.',
    'Weak accuracy and poor computer comfort reduce performance.',
    'published', 0, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'jobs';

-- 4. Home Tiffin Service
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Home Tiffin Service', 'home-tiffin-service',
    'Home-based food service opportunity with low to moderate startup investment.',
    'A tiffin service can be started from home by preparing meals for students, office workers, or local families on a subscription or daily basis.',
    'home_based_work',
    'Suitable for homemakers, small-capital seekers, and families who can help with cooking and delivery.',
    'Not ideal for users without a home kitchen setup, time discipline, or food preparation comfort.',
    18, 60, 'none', 'secondary',
    'no', 'basic', 'medium', 'yes',
    5000, 25000, 10000, 40000, 'within_1_week', 'high',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'helpful', 'helpful', 'Basic kitchen utensils, containers, and packaging supplies.', 'yes', 'medium',
    'medium', 'high', 'high', 'high', 'medium',
    'Works best in areas with students, office workers, or working families.',
    'Depends on steady raw material access and food cost control.',
    'Can begin within 1 to 2 weeks',
    'Consistent taste, hygiene, and WhatsApp-based local promotion help growth.',
    'Poor quality control and delayed deliveries hurt repeat business.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'home-based-work';

-- 5. Tailoring and Alteration Service
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Tailoring and Alteration Service', 'tailoring-and-alteration-service',
    'Flexible home-based or shop-based service for users with stitching skills.',
    'Tailoring and alteration work includes blouse stitching, school uniform repairs, daily wear adjustments, fall-pico work, and custom small garment stitching.',
    'home_based_work',
    'Suitable for homemakers and users with sewing skills or willingness to learn.',
    'Not ideal for users who do not enjoy detail-oriented manual work.',
    18, 60, 'none', 'secondary',
    'preferred', 'none', 'medium', 'yes',
    7000, 30000, 8000, 35000, 'within_1_month', 'medium',
    'no', 'helpful', 'no', 'no', 'helpful',
    'no', 'required', 'Sewing machine, scissors, measuring tape, and basic tailoring tools.', 'yes', 'medium',
    'low', 'medium', 'high', 'high', 'high',
    'Works in almost all populated jobs_districts if service quality is good.',
    'Basic cloth accessories and tailoring materials are needed.',
    'Can start earning in 2 to 4 weeks',
    'Start with alterations and referrals from neighbors to build trust.',
    'Taking poorly measured orders can create customer dissatisfaction.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'home-based-work';

-- 6. Tuition / Coaching from Home
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Tuition / Coaching from Home', 'tuition-coaching-from-home',
    'Low-investment teaching opportunity for educated users.',
    'Home tuition or small coaching can be started for school students in subjects such as maths, English, science, or basic learning support.',
    'home_based_work',
    'Suitable for educated youth, homemakers, and unemployed adults with subject comfort.',
    'Not suitable for users uncomfortable teaching or managing children/students.',
    18, 60, 'higher_secondary', 'graduate',
    'no', 'basic', 'low', 'yes',
    1000, 10000, 5000, 30000, 'within_1_week', 'high',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'no', 'helpful', 'Whiteboard, notebooks, chairs, and study materials help.', 'yes', 'low',
    'low', 'high', 'high', 'high', 'high',
    'Works especially well in education-focused jobs_districts and residential areas.',
    NULL,
    'Often within 1 to 3 weeks',
    'Strong word-of-mouth and consistent student results increase growth.',
    'Taking too many subjects without mastery can harm reputation.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'home-based-work';

-- 7. Beauty / Mehendi Service from Home
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Beauty / Mehendi Service from Home', 'beauty-mehendi-service-from-home',
    'Home-based service opportunity for users with beauty or mehendi skills.',
    'Users can offer basic beauty services or mehendi application from home or on-call for weddings, festivals, and local events.',
    'home_based_work',
    'Suitable for homemakers and small-capital seekers with practical service skills.',
    'Not ideal for users who do not enjoy direct client service or irregular event-based work.',
    18, 55, 'none', 'secondary',
    'preferred', 'basic', 'low', 'yes',
    3000, 20000, 6000, 35000, 'within_1_week', 'medium',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'helpful', 'required', 'Beauty kit, mehendi cones, mirror setup, and basic supplies.', 'yes', 'low',
    'medium', 'medium', 'high', 'high', 'medium',
    'Demand increases around weddings, events, and festive seasons.',
    'Depends on quality products and basic client setup.',
    'Can start in 1 to 2 weeks',
    'Portfolio photos and local WhatsApp promotion help early bookings.',
    'Low hygiene standards or inconsistent service quality reduce trust.',
    'published', 0, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'home-based-work';

-- 8. Mobile Phone Repair Service
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Mobile Phone Repair Service', 'mobile-phone-repair-service',
    'Skill-based self-employment option with demand in both towns and cities.',
    'Mobile repair work includes basic troubleshooting, screen replacement, charging issues, battery issues, software resets, and accessory sales.',
    'self_employment',
    'Suitable for youth and unemployed adults willing to learn a practical technical skill.',
    'Not suitable for users who want zero-skill-entry options or dislike precision work.',
    18, 50, 'secondary', 'higher_secondary',
    'preferred', 'basic', 'medium', 'partial',
    10000, 50000, 12000, 50000, 'within_1_month', 'high',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'no', 'required', 'Repair toolkit, magnifier, screwdrivers, and spare-part access.', 'no', 'medium',
    'medium', 'high', 'high', 'high', 'high',
    'Demand exists across urban and semi-urban jobs_districts where smartphone usage is high.',
    'Access to spare parts and tools affects service quality.',
    'Usually after 3 to 6 weeks if skill is ready',
    'Start with simple repairs and honest pricing to build trust.',
    'Overcommitting complex repairs too early can damage reputation and devices.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'self-employment';

-- 9. Home Cleaning / Local Cleaning Service
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Home Cleaning / Local Cleaning Service', 'home-cleaning-local-cleaning-service',
    'Service-based option with relatively quick income in urban and semi-urban areas.',
    'This opportunity involves offering household cleaning, deep cleaning, move-in/move-out cleaning, or small office cleaning in local neighborhoods.',
    'self_employment',
    'Suitable for users needing quick income and willing to do active physical work.',
    'Not suitable for users who need only home-based work or cannot do manual activity.',
    18, 55, 'none', 'secondary',
    'no', 'basic', 'high', 'no',
    2000, 15000, 10000, 30000, 'within_1_week', 'medium',
    'no', 'no', 'helpful', 'no', 'helpful',
    'helpful', 'required', 'Basic cleaning supplies, gloves, cloths, mop, and bucket.', 'yes', 'high',
    'low', 'medium', 'high', 'medium', 'low',
    'Works best in apartment-heavy and service-economy jobs_districts.',
    'Supply cost management matters.',
    'Can begin within days',
    'Reliability and cleanliness standards drive repeat referrals.',
    'Irregular scheduling and weak punctuality hurt trust quickly.',
    'published', 0, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'self-employment';

-- 10. Tea and Snacks Stall
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Tea and Snacks Stall', 'tea-and-snacks-stall',
    'Popular micro-business option in high-footfall areas with low to moderate capital.',
    'A tea and snacks stall can operate near offices, markets, bus stands, schools, or busy roads, serving affordable refreshments with repeat demand.',
    'micro_business',
    'Suitable for small-capital seekers with local market sense and willingness to manage daily operations.',
    'Not ideal for users who cannot handle daily physical work, customer-facing activity, or supply management.',
    18, 60, 'none', 'secondary',
    'no', 'basic', 'medium', 'no',
    10000, 50000, 15000, 50000, 'within_1_week', 'high',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'helpful', 'required', 'Cooking setup, utensils, stove, serving material, and basic stall setup.', 'yes', 'medium',
    'medium', 'high', 'high', 'high', 'medium',
    'Strongly depends on location footfall and pricing strategy.',
    'Requires regular raw material supply and food hygiene.',
    'Often within 1 to 2 weeks',
    'Choose the right location and keep quality consistent.',
    'Poor location choice is one of the biggest failure reasons.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'micro-business';

-- 11. Pickle / Papad / Spice Making Business
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Pickle / Papad / Spice Making Business', 'pickle-papad-spice-making-business',
    'Home-based micro-business using food preparation skills and local sales channels.',
    'Users can prepare packaged homemade products such as pickles, papad, masala mixes, or snacks for neighborhood sales, local stores, and WhatsApp orders.',
    'micro_business',
    'Suitable for homemakers and family-supported home entrepreneurs.',
    'Not ideal for users who cannot maintain consistency, hygiene, or packaging discipline.',
    18, 60, 'none', 'secondary',
    'no', 'basic', 'medium', 'yes',
    5000, 30000, 8000, 40000, 'within_1_month', 'high',
    'no', 'helpful', 'helpful', 'no', 'helpful',
    'helpful', 'required', 'Basic kitchen tools, storage jars, packaging materials, and working space.', 'yes', 'medium',
    'medium', 'high', 'high', 'high', 'high',
    'Works well where local trust and word-of-mouth support food sales.',
    'Depends on ingredient sourcing, packaging, and shelf-life handling.',
    'Usually within 2 to 4 weeks',
    'Begin with a few well-made products and gather repeat customers.',
    'Too many products too early can create waste and inconsistency.',
    'published', 1, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'micro-business';

-- 12. Dairy / Small Milk Supply Business
INSERT INTO jobs_opportunities (
    category_id, title, slug, short_summary, full_description, opportunity_type,
    suitable_for_text, not_suitable_for_text,
    min_age, max_age, min_education_level, preferred_education_level,
    prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
    investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
    land_required, shop_space_required, internet_required, computer_required, smartphone_required,
    vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
    risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
    market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
    status, featured_flag, published_at
)
SELECT
    c.id, 'Dairy / Small Milk Supply Business', 'dairy-small-milk-supply-business',
    'Resource-based rural and semi-urban micro-business for users with space and livestock readiness.',
    'Small-scale milk supply can be built around one or more dairy animals, local delivery, neighborhood subscriptions, and sale of related products such as curd or ghee.',
    'micro_business',
    'Suitable for users with land/space, family support, and rural or semi-urban access.',
    'Not ideal for users without space, daily routine discipline, or willingness to manage livestock care.',
    18, 60, 'none', 'secondary',
    'preferred', 'none', 'high', 'partial',
    30000, 150000, 15000, 60000, 'more_than_1_month', 'high',
    'helpful', 'helpful', 'no', 'no', 'helpful',
    'helpful', 'required', 'Animal care setup, feeding arrangements, containers, and local delivery support.', 'yes', 'high',
    'medium', 'high', 'low', 'high', 'high',
    'Best in rural and semi-urban markets with consistent local demand.',
    'Feed cost, veterinary support, and animal health matter heavily.',
    'Usually after 1 to 2 months',
    'Start small, ensure hygiene, and build regular local customers.',
    'Underestimating daily care and recurring costs creates problems.',
    'published', 0, NOW()
FROM jobs_opportunity_categories c
WHERE c.slug = 'micro-business';

-- ---------------------------------------------------------
-- TAG MAPPING
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'home-tiffin-service' AND t.slug IN ('low-investment', 'for-homemakers', 'from-home', 'quick-income');

INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'tailoring-and-alteration-service' AND t.slug IN ('for-homemakers', 'from-home', 'beginner-friendly');

INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'tuition-coaching-from-home' AND t.slug IN ('from-home', 'part-time', 'beginner-friendly');

INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'delivery-partner' AND t.slug IN ('quick-income', 'urban-friendly');

INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'dairy-small-milk-supply-business' AND t.slug IN ('rural-friendly');

INSERT INTO jobs_opportunity_tag_map (opportunity_id, tag_id)
SELECT o.id, t.id
FROM jobs_opportunities o
JOIN jobs_opportunity_tags t
WHERE o.slug = 'tea-and-snacks-stall' AND t.slug IN ('low-investment', 'quick-income');

-- ---------------------------------------------------------
-- SAMPLE STEPS
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 1, 'Identify target customers', 'Find office workers, students, families, or local neighborhoods likely to need this service.'
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 2, 'Plan menu and pricing', 'Start with a small, repeatable menu and set prices carefully after estimating food costs.'
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 3, 'Test with a few customers', 'Start with a few local users and improve quality based on feedback.'
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 1, 'Assess your current skill level', 'Decide whether you can begin with repairs or need a short training period first.'
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 2, 'Buy basic repair tools', 'Purchase only essential tools initially to keep startup cost low.'
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 3, 'Start with simple jobs', 'Begin with common and low-risk repairs while building confidence and reputation.'
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 1, 'Choose a high-footfall location', 'Study local foot traffic before deciding where to operate.'
FROM jobs_opportunities WHERE slug = 'tea-and-snacks-stall';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 2, 'Start with limited menu items', 'Keep your menu small and easy to prepare consistently.'
FROM jobs_opportunities WHERE slug = 'tea-and-snacks-stall';

INSERT INTO jobs_opportunity_steps (opportunity_id, step_no, step_title, step_description)
SELECT id, 3, 'Track daily costs and sales', 'Monitor earnings carefully so you know your real profit.'
FROM jobs_opportunities WHERE slug = 'tea-and-snacks-stall';

-- ---------------------------------------------------------
-- SAMPLE RISKS
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_risks (opportunity_id, risk_title, risk_description, sort_order)
SELECT id, 'Inconsistent quality', 'If food taste or hygiene changes frequently, repeat customers may stop ordering.', 1
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_risks (opportunity_id, risk_title, risk_description, sort_order)
SELECT id, 'Late delivery', 'Even good food can lose customers if delivery timing is unreliable.', 2
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_risks (opportunity_id, risk_title, risk_description, sort_order)
SELECT id, 'Complex repairs too early', 'Attempting advanced mobile repairs too soon can damage devices and customer trust.', 1
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

INSERT INTO jobs_opportunity_risks (opportunity_id, risk_title, risk_description, sort_order)
SELECT id, 'Weak location choice', 'A tea stall in a low-footfall location may struggle even if the product is good.', 1
FROM jobs_opportunities WHERE slug = 'tea-and-snacks-stall';

INSERT INTO jobs_opportunity_risks (opportunity_id, risk_title, risk_description, sort_order)
SELECT id, 'Recurring animal care costs', 'Feed and health care costs must be managed carefully in dairy-based work.', 1
FROM jobs_opportunities WHERE slug = 'dairy-small-milk-supply-business';

-- ---------------------------------------------------------
-- OPPORTUNITY FAQS
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_faqs (opportunity_id, question, answer, sort_order, status)
SELECT id, 'Can I start this from a home kitchen?', 'Yes, many users begin from home if they can maintain hygiene, consistency, and packaging discipline.', 1, 'active'
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_faqs (opportunity_id, question, answer, sort_order, status)
SELECT id, 'Do I need formal training first?', 'Formal training is not always required, but even a short practical course can help reduce mistakes and build confidence.', 1, 'active'
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

-- ---------------------------------------------------------
-- LEARNING RESOURCES
-- ---------------------------------------------------------
INSERT INTO jobs_opportunity_learning_resources (opportunity_id, title, resource_type, provider_name, resource_url, description, status, sort_order)
SELECT id, 'Basic Food Safety and Hygiene Checklist', 'article', 'Internal', NULL, 'A simple starter checklist for food cleanliness, storage, and packaging.', 'active', 1
FROM jobs_opportunities WHERE slug = 'home-tiffin-service';

INSERT INTO jobs_opportunity_learning_resources (opportunity_id, title, resource_type, provider_name, resource_url, description, status, sort_order)
SELECT id, 'Beginner Mobile Repair Skill Path', 'article', 'Internal', NULL, 'Suggested sequence of simple repair skills to learn before offering paid service.', 'active', 1
FROM jobs_opportunities WHERE slug = 'mobile-phone-repair-service';

-- ---------------------------------------------------------
-- RELATED jobs_opportunities
-- ---------------------------------------------------------
INSERT INTO jobs_related_opportunities (opportunity_id, related_opportunity_id, sort_order)
SELECT o1.id, o2.id, 1
FROM jobs_opportunities o1
JOIN jobs_opportunities o2
WHERE o1.slug = 'home-tiffin-service'
  AND o2.slug = 'pickle-papad-spice-making-business';

INSERT INTO jobs_related_opportunities (opportunity_id, related_opportunity_id, sort_order)
SELECT o1.id, o2.id, 1
FROM jobs_opportunities o1
JOIN jobs_opportunities o2
WHERE o1.slug = 'tuition-coaching-from-home'
  AND o2.slug = 'data-entry-office-support-assistant';

INSERT INTO jobs_related_opportunities (opportunity_id, related_opportunity_id, sort_order)
SELECT o1.id, o2.id, 1
FROM jobs_opportunities o1
JOIN jobs_opportunities o2
WHERE o1.slug = 'tea-and-snacks-stall'
  AND o2.slug = 'home-tiffin-service';

-- ---------------------------------------------------------
-- LOCATION RULES
-- ---------------------------------------------------------

-- Delivery Partner stronger in large urban jobs_districts
INSERT INTO jobs_opportunity_location_rules (opportunity_id, district_id, suitability_level, notes)
SELECT o.id, d.id, 'high', 'Strong platform-based delivery demand in major urban centers.'
FROM jobs_opportunities o
JOIN jobs_districts d
WHERE o.slug = 'delivery-partner'
  AND d.slug IN ('new-delhi', 'mumbai', 'pune', 'bengaluru-urban', 'gurugram', 'noida', 'chennai', 'hyderabad', 'kolkata', 'ahmedabad');

-- Home tiffin strong in student/office/service cities
INSERT INTO jobs_opportunity_location_rules (opportunity_id, district_id, suitability_level, notes)
SELECT o.id, d.id, 'high', 'Good demand from students, office workers, and working families.'
FROM jobs_opportunities o
JOIN jobs_districts d
WHERE o.slug = 'home-tiffin-service'
  AND d.slug IN ('new-delhi', 'mumbai', 'pune', 'bengaluru-urban', 'kota', 'varanasi', 'noida', 'gurugram', 'hyderabad', 'chennai');

-- Dairy stronger in rural/semi-urban jobs_districts
INSERT INTO jobs_opportunity_location_rules (opportunity_id, district_id, suitability_level, notes)
SELECT o.id, d.id, 'high', 'Suitable where space, livestock care, and regular local demand are practical.'
FROM jobs_opportunities o
JOIN jobs_districts d
WHERE o.slug = 'dairy-small-milk-supply-business'
  AND d.slug IN ('bareilly', 'gaya', 'warangal', 'mysuru', 'dehradun');

-- Data entry stronger in service/office jobs_districts
INSERT INTO jobs_opportunity_location_rules (opportunity_id, district_id, suitability_level, notes)
SELECT o.id, d.id, 'high', 'Stronger demand in administrative, office, and service-economy jobs_districts.'
FROM jobs_opportunities o
JOIN jobs_districts d
WHERE o.slug = 'data-entry-office-support-assistant'
  AND d.slug IN ('new-delhi', 'noida', 'gurugram', 'mumbai', 'pune', 'bengaluru-urban', 'hyderabad', 'chennai');

-- Tea stall high in busy commercial / transport areas
INSERT INTO jobs_opportunity_location_rules (opportunity_id, district_id, suitability_level, notes)
SELECT o.id, d.id, 'high', 'Strong potential in high-footfall jobs_districts with office, market, or travel movement.'
FROM jobs_opportunities o
JOIN jobs_districts d
WHERE o.slug = 'tea-and-snacks-stall'
  AND d.slug IN ('new-delhi', 'lucknow', 'kanpur-nagar', 'mumbai', 'pune', 'ahmedabad', 'surat', 'jaipur', 'bhopal', 'patna');

-- ---------------------------------------------------------
-- SITE FAQS
-- ---------------------------------------------------------
INSERT INTO jobs_site_faqs (question, answer, sort_order, status)
VALUES
('What kind of jobs_opportunities can I discover here?', 'You can explore jobs, home-based work, self-employment, and low-investment micro-business options based on your profile and location.', 1, 'active'),
('Do I need to register to view recommendations?', 'You should be able to browse and discover jobs_opportunities as a guest. Registration can be required for saving and managing your shortlist.', 2, 'active'),
('Are the income estimates guaranteed?', 'No. The estimates are indicative ranges and actual earnings depend on skill, location, demand, consistency, and execution.', 3, 'active');

-- ---------------------------------------------------------
-- FEATURED SECTIONS
-- ---------------------------------------------------------
INSERT INTO jobs_featured_sections (section_key, title, subtitle, status, sort_order)
VALUES
('homepage_hero', 'Find work and earning options that fit your life', 'Discover jobs, home-based work, self-employment, and micro-business ideas based on your situation.', 'active', 1),
('featured_opportunities', 'Featured jobs_opportunities', 'A few strong options to explore first.', 'active', 2);