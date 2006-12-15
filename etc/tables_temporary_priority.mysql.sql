CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_required_impression (
  ad_id INTEGER UNSIGNED NOT NULL,
  required_impressions INTEGER UNSIGNED NOT NULL,
  INDEX tmp_ad_required_impression_ad_id(ad_id)
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_zone_impression (
  ad_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  required_impressions INTEGER UNSIGNED NOT NULL,
  requested_impressions INTEGER UNSIGNED NOT NULL,
  INDEX tmp_ad_zone_impression_ad_id(ad_id),
  INDEX tmp_ad_zone_impression_zone_id(zone_id)
);
