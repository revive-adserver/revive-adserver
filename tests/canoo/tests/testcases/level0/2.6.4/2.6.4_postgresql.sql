--
-- PostgreSQL database dump
--

-- Started on 2009-03-06 14:13:30 CET

--SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 472 (class 2612 OID 1013036)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: -
--

--CREATE PROCEDURAL LANGUAGE plpgsql;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1648 (class 1259 OID 1954483)
-- Dependencies: 2012 3
-- Name: ox_account_preference_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_account_preference_assoc (
    account_id integer NOT NULL,
    preference_id integer NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


--
-- TOC entry 1649 (class 1259 OID 1954492)
-- Dependencies: 3
-- Name: ox_account_user_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_account_user_assoc (
    account_id integer NOT NULL,
    user_id integer NOT NULL,
    linked timestamp without time zone
);


--
-- TOC entry 1650 (class 1259 OID 1954498)
-- Dependencies: 2013 3
-- Name: ox_account_user_permission_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_account_user_permission_assoc (
    account_id integer NOT NULL,
    user_id integer NOT NULL,
    permission_id integer NOT NULL,
    is_allowed smallint DEFAULT 1 NOT NULL
);


--
-- TOC entry 1652 (class 1259 OID 1954506)
-- Dependencies: 2015 2016 2017 2018 3
-- Name: ox_accounts; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_accounts (
    account_id integer NOT NULL,
    account_type character varying(16) DEFAULT ''::character varying NOT NULL,
    account_name character varying(255) DEFAULT NULL::character varying,
    m2m_password character varying(32) DEFAULT NULL::character varying,
    m2m_ticket character varying(32) DEFAULT NULL::character varying
);


--
-- TOC entry 1653 (class 1259 OID 1954517)
-- Dependencies: 2019 2020 2021 2022 2023 2024 3
-- Name: ox_acls; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_acls (
    bannerid integer DEFAULT 0 NOT NULL,
    logical character varying(3) DEFAULT 'and'::character varying NOT NULL,
    type character varying(32) DEFAULT ''::character varying NOT NULL,
    comparison character(2) DEFAULT '=='::bpchar NOT NULL,
    data text DEFAULT ''::text NOT NULL,
    executionorder integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1654 (class 1259 OID 1954532)
-- Dependencies: 2025 2026 2027 2028 2029 2030 3
-- Name: ox_acls_channel; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_acls_channel (
    channelid integer DEFAULT 0 NOT NULL,
    logical character varying(3) DEFAULT 'and'::character varying NOT NULL,
    type character varying(32) DEFAULT ''::character varying NOT NULL,
    comparison character(2) DEFAULT '=='::bpchar NOT NULL,
    data text DEFAULT ''::text NOT NULL,
    executionorder integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1656 (class 1259 OID 1954549)
-- Dependencies: 3
-- Name: ox_ad_category_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_ad_category_assoc (
    ad_category_assoc_id integer NOT NULL,
    category_id integer NOT NULL,
    ad_id integer NOT NULL
);


--
-- TOC entry 1658 (class 1259 OID 1954557)
-- Dependencies: 2033 2034 2035 2036 3
-- Name: ox_ad_zone_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_ad_zone_assoc (
    ad_zone_assoc_id integer NOT NULL,
    zone_id integer,
    ad_id integer,
    priority double precision DEFAULT 0,
    link_type smallint DEFAULT 1 NOT NULL,
    priority_factor double precision DEFAULT 0,
    to_be_delivered smallint DEFAULT 1 NOT NULL
);


--
-- TOC entry 1660 (class 1259 OID 1954571)
-- Dependencies: 2038 2039 2040 2041 2042 2043 2044 3
-- Name: ox_affiliates; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_affiliates (
    affiliateid integer NOT NULL,
    agencyid integer DEFAULT 0 NOT NULL,
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    mnemonic character varying(5) DEFAULT ''::character varying NOT NULL,
    comments text,
    contact character varying(255) DEFAULT NULL::character varying,
    email character varying(64) DEFAULT ''::character varying NOT NULL,
    website character varying(255) DEFAULT NULL::character varying,
    updated timestamp without time zone,
    an_website_id integer,
    oac_country_code character(2) DEFAULT ''::bpchar NOT NULL,
    oac_language_id integer,
    oac_category_id integer,
    as_website_id integer,
    account_id integer
);


--
-- TOC entry 1661 (class 1259 OID 1954590)
-- Dependencies: 2045 2046 2047 2048 2049 2050 2051 2052 2053 2054 2055 2056 3
-- Name: ox_affiliates_extra; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_affiliates_extra (
    affiliateid integer NOT NULL,
    address text,
    city character varying(255) DEFAULT NULL::character varying,
    postcode character varying(64) DEFAULT NULL::character varying,
    country character varying(255) DEFAULT NULL::character varying,
    phone character varying(64) DEFAULT NULL::character varying,
    fax character varying(64) DEFAULT NULL::character varying,
    account_contact character varying(255) DEFAULT NULL::character varying,
    payee_name character varying(255) DEFAULT NULL::character varying,
    tax_id character varying(64) DEFAULT NULL::character varying,
    mode_of_payment character varying(64) DEFAULT NULL::character varying,
    currency character varying(64) DEFAULT NULL::character varying,
    unique_users integer,
    unique_views integer,
    page_rank integer,
    category character varying(255) DEFAULT NULL::character varying,
    help_file character varying(255) DEFAULT NULL::character varying
);


--
-- TOC entry 1663 (class 1259 OID 1954612)
-- Dependencies: 2058 2059 2060 2061 2062 3
-- Name: ox_agency; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_agency (
    agencyid integer NOT NULL,
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    contact character varying(255) DEFAULT NULL::character varying,
    email character varying(64) DEFAULT ''::character varying NOT NULL,
    logout_url character varying(255) DEFAULT NULL::character varying,
    active smallint DEFAULT 0,
    updated timestamp without time zone,
    account_id integer
);


--
-- TOC entry 1664 (class 1259 OID 1954628)
-- Dependencies: 2063 2064 3
-- Name: ox_application_variable; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_application_variable (
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


--
-- TOC entry 1666 (class 1259 OID 1954640)
-- Dependencies: 2066 2067 2068 2069 2070 3
-- Name: ox_audit; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_audit (
    auditid integer NOT NULL,
    actionid integer NOT NULL,
    context character varying(255) DEFAULT ''::character varying NOT NULL,
    contextid integer,
    parentid integer,
    details text DEFAULT ''::text NOT NULL,
    userid integer DEFAULT 0 NOT NULL,
    username character varying(64) DEFAULT NULL::character varying,
    usertype smallint DEFAULT 0 NOT NULL,
    updated timestamp without time zone,
    account_id integer NOT NULL,
    advertiser_account_id integer,
    website_account_id integer
);


--
-- TOC entry 1668 (class 1259 OID 1954664)
-- Dependencies: 2072 2073 2074 2075 2076 2077 2078 2079 2080 2081 2082 2083 2084 2085 2086 2087 2088 2089 2090 2091 2092 2093 2094 2095 2096 2097 2098 2099 2100 2101 2102 2103 2104 2105 2106 3
-- Name: ox_banners; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_banners (
    bannerid integer NOT NULL,
    campaignid integer DEFAULT 0 NOT NULL,
    contenttype text DEFAULT 'gif'::text NOT NULL,
    pluginversion integer DEFAULT 0 NOT NULL,
    storagetype text DEFAULT 'sql'::text NOT NULL,
    filename character varying(255) DEFAULT ''::character varying NOT NULL,
    imageurl character varying(255) DEFAULT ''::character varying NOT NULL,
    htmltemplate text DEFAULT ''::text NOT NULL,
    htmlcache text DEFAULT ''::text NOT NULL,
    width smallint DEFAULT 0 NOT NULL,
    height smallint DEFAULT 0 NOT NULL,
    weight smallint DEFAULT 1 NOT NULL,
    seq smallint DEFAULT 0 NOT NULL,
    target character varying(16) DEFAULT ''::character varying NOT NULL,
    url text DEFAULT ''::text NOT NULL,
    alt character varying(255) DEFAULT ''::character varying NOT NULL,
    statustext character varying(255) DEFAULT ''::character varying NOT NULL,
    bannertext text DEFAULT ''::text NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    autohtml boolean DEFAULT true NOT NULL,
    adserver character varying(50) DEFAULT ''::character varying NOT NULL,
    block integer DEFAULT 0 NOT NULL,
    capping integer DEFAULT 0 NOT NULL,
    session_capping integer DEFAULT 0 NOT NULL,
    compiledlimitation text DEFAULT ''::text NOT NULL,
    acl_plugins text,
    append text DEFAULT ''::text NOT NULL,
    appendtype smallint DEFAULT 0 NOT NULL,
    bannertype smallint DEFAULT 0 NOT NULL,
    alt_filename character varying(255) DEFAULT ''::character varying NOT NULL,
    alt_imageurl character varying(255) DEFAULT ''::character varying NOT NULL,
    alt_contenttype text DEFAULT 'gif'::text NOT NULL,
    comments text,
    updated timestamp without time zone,
    acls_updated timestamp without time zone,
    keyword character varying(255) DEFAULT ''::character varying NOT NULL,
    transparent smallint DEFAULT 0 NOT NULL,
    parameters text,
    an_banner_id integer,
    as_banner_id integer,
    status integer DEFAULT 0 NOT NULL,
    ad_direct_status smallint DEFAULT 0 NOT NULL,
    ad_direct_rejection_reason_id smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1670 (class 1259 OID 1954711)
-- Dependencies: 2108 2109 2110 2111 2112 2113 2114 2115 2116 2117 2118 2119 2120 2121 2122 2123 2124 2125 2126 2127 2128 3
-- Name: ox_campaigns; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_campaigns (
    campaignid integer NOT NULL,
    campaignname character varying(255) DEFAULT ''::character varying NOT NULL,
    clientid integer DEFAULT 0 NOT NULL,
    views integer DEFAULT (-1),
    clicks integer DEFAULT (-1),
    conversions integer DEFAULT (-1),
    expire date,
    activate date,
    priority integer DEFAULT 0 NOT NULL,
    weight smallint DEFAULT 1 NOT NULL,
    target_impression integer DEFAULT 0 NOT NULL,
    target_click integer DEFAULT 0 NOT NULL,
    target_conversion integer DEFAULT 0 NOT NULL,
    anonymous boolean DEFAULT false NOT NULL,
    companion smallint DEFAULT 0,
    comments text,
    revenue numeric(10,4) DEFAULT NULL::numeric,
    revenue_type smallint,
    updated timestamp without time zone,
    block integer DEFAULT 0 NOT NULL,
    capping integer DEFAULT 0 NOT NULL,
    session_capping integer DEFAULT 0 NOT NULL,
    an_campaign_id integer,
    as_campaign_id integer,
    status integer DEFAULT 0 NOT NULL,
    an_status integer DEFAULT 0 NOT NULL,
    as_reject_reason integer DEFAULT 0 NOT NULL,
    hosted_views integer DEFAULT 0 NOT NULL,
    hosted_clicks integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1672 (class 1259 OID 1954744)
-- Dependencies: 2130 2131 2132 2133 2134 3
-- Name: ox_campaigns_trackers; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_campaigns_trackers (
    campaign_trackerid integer NOT NULL,
    campaignid integer DEFAULT 0 NOT NULL,
    trackerid integer DEFAULT 0 NOT NULL,
    viewwindow integer DEFAULT 0 NOT NULL,
    clickwindow integer DEFAULT 0 NOT NULL,
    status smallint DEFAULT 4 NOT NULL
);


--
-- TOC entry 1674 (class 1259 OID 1954759)
-- Dependencies: 2136 3
-- Name: ox_category; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_category (
    category_id integer NOT NULL,
    name character varying(255) DEFAULT NULL::character varying
);


--
-- TOC entry 1676 (class 1259 OID 1954768)
-- Dependencies: 2138 2139 2140 2141 2142 3
-- Name: ox_channel; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_channel (
    channelid integer NOT NULL,
    agencyid integer DEFAULT 0 NOT NULL,
    affiliateid integer DEFAULT 0 NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    description character varying(255) DEFAULT NULL::character varying,
    compiledlimitation text DEFAULT ''::text NOT NULL,
    acl_plugins text,
    active smallint,
    comments text,
    updated timestamp without time zone,
    acls_updated timestamp without time zone
);


--
-- TOC entry 1678 (class 1259 OID 1954784)
-- Dependencies: 2144 2145 2146 2147 2148 2149 2150 2151 2152 3
-- Name: ox_clients; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_clients (
    clientid integer NOT NULL,
    agencyid integer DEFAULT 0 NOT NULL,
    clientname character varying(255) DEFAULT ''::character varying NOT NULL,
    contact character varying(255) DEFAULT NULL::character varying,
    email character varying(64) DEFAULT ''::character varying NOT NULL,
    report boolean DEFAULT true NOT NULL,
    reportinterval integer DEFAULT 7 NOT NULL,
    reportlastdate date,
    reportdeactivate boolean DEFAULT true NOT NULL,
    comments text,
    updated timestamp without time zone,
    lb_reporting smallint DEFAULT 0 NOT NULL,
    an_adnetwork_id integer,
    as_advertiser_id integer,
    account_id integer,
    advertiser_limitation smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1680 (class 1259 OID 1954807)
-- Dependencies: 2154 2155 2156 2157 2158 2159 3
-- Name: ox_data_intermediate_ad; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_intermediate_ad (
    data_intermediate_ad_id bigint NOT NULL,
    date_time timestamp without time zone,
    operation_interval integer NOT NULL,
    operation_interval_id integer NOT NULL,
    interval_start timestamp without time zone,
    interval_end timestamp without time zone,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    requests integer DEFAULT 0 NOT NULL,
    impressions integer DEFAULT 0 NOT NULL,
    clicks integer DEFAULT 0 NOT NULL,
    conversions integer DEFAULT 0 NOT NULL,
    total_basket_value numeric(10,4) DEFAULT 0.0000 NOT NULL,
    total_num_items integer DEFAULT 0 NOT NULL,
    updated timestamp without time zone
);


--
-- TOC entry 1682 (class 1259 OID 1954825)
-- Dependencies: 2161 2162 2163 2164 2165 2166 2167 2168 2169 2170 2171 2172 2173 2174 2175 2176 2177 2178 2179 2180 2181 2182 2183 2184 2185 2186 2187 2188 2189 2190 2191 2192 2193 3
-- Name: ox_data_intermediate_ad_connection; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_intermediate_ad_connection (
    data_intermediate_ad_connection_id bigint NOT NULL,
    server_raw_ip character varying(16) DEFAULT ''::character varying NOT NULL,
    server_raw_tracker_impression_id bigint NOT NULL,
    viewer_id character varying(32) DEFAULT NULL::character varying,
    viewer_session_id character varying(32) DEFAULT NULL::character varying,
    tracker_date_time timestamp without time zone,
    connection_date_time timestamp without time zone,
    tracker_id integer NOT NULL,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    tracker_channel character varying(255) DEFAULT NULL::character varying,
    connection_channel character varying(255) DEFAULT NULL::character varying,
    tracker_channel_ids character varying(64) DEFAULT NULL::character varying,
    connection_channel_ids character varying(64) DEFAULT NULL::character varying,
    tracker_language character varying(13) DEFAULT NULL::character varying,
    connection_language character varying(13) DEFAULT NULL::character varying,
    tracker_ip_address character varying(16) DEFAULT NULL::character varying,
    connection_ip_address character varying(16) DEFAULT NULL::character varying,
    tracker_host_name character varying(255) DEFAULT NULL::character varying,
    connection_host_name character varying(255) DEFAULT NULL::character varying,
    tracker_country character(2) DEFAULT NULL::bpchar,
    connection_country character(2) DEFAULT NULL::bpchar,
    tracker_https integer,
    connection_https integer,
    tracker_domain character varying(255) DEFAULT NULL::character varying,
    connection_domain character varying(255) DEFAULT NULL::character varying,
    tracker_page character varying(255) DEFAULT NULL::character varying,
    connection_page character varying(255) DEFAULT NULL::character varying,
    tracker_query character varying(255) DEFAULT NULL::character varying,
    connection_query character varying(255) DEFAULT NULL::character varying,
    tracker_referer character varying(255) DEFAULT NULL::character varying,
    connection_referer character varying(255) DEFAULT NULL::character varying,
    tracker_search_term character varying(255) DEFAULT NULL::character varying,
    connection_search_term character varying(255) DEFAULT NULL::character varying,
    tracker_user_agent character varying(255) DEFAULT NULL::character varying,
    connection_user_agent character varying(255) DEFAULT NULL::character varying,
    tracker_os character varying(32) DEFAULT NULL::character varying,
    connection_os character varying(32) DEFAULT NULL::character varying,
    tracker_browser character varying(32) DEFAULT NULL::character varying,
    connection_browser character varying(32) DEFAULT NULL::character varying,
    connection_action integer,
    connection_window integer,
    connection_status integer DEFAULT 4 NOT NULL,
    inside_window smallint DEFAULT 0 NOT NULL,
    comments text,
    updated timestamp without time zone
);


--
-- TOC entry 1684 (class 1259 OID 1954874)
-- Dependencies: 2195 3
-- Name: ox_data_intermediate_ad_variable_value; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_intermediate_ad_variable_value (
    data_intermediate_ad_variable_value_id bigint NOT NULL,
    data_intermediate_ad_connection_id bigint NOT NULL,
    tracker_variable_id integer NOT NULL,
    value character varying(50) DEFAULT NULL::character varying
);


--
-- TOC entry 1685 (class 1259 OID 1954884)
-- Dependencies: 2196 2197 2198 2199 2200 2201 2202 2203 2204 2205 2206 2207 2208 2209 2210 2211 2212 2213 2214 2215 2216 2217 2218 2219 2220 2221 3
-- Name: ox_data_raw_ad_click; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_raw_ad_click (
    viewer_id character varying(32) DEFAULT NULL::character varying,
    viewer_session_id character varying(32) DEFAULT NULL::character varying,
    date_time timestamp without time zone,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    channel character varying(255) DEFAULT NULL::character varying,
    channel_ids character varying(64) DEFAULT NULL::character varying,
    language character varying(32) DEFAULT NULL::character varying,
    ip_address character varying(16) DEFAULT NULL::character varying,
    host_name character varying(255) DEFAULT NULL::character varying,
    country character(2) DEFAULT NULL::bpchar,
    https smallint,
    domain character varying(255) DEFAULT NULL::character varying,
    page character varying(255) DEFAULT NULL::character varying,
    query character varying(255) DEFAULT NULL::character varying,
    referer character varying(255) DEFAULT NULL::character varying,
    search_term character varying(255) DEFAULT NULL::character varying,
    user_agent character varying(255) DEFAULT NULL::character varying,
    os character varying(32) DEFAULT NULL::character varying,
    browser character varying(32) DEFAULT NULL::character varying,
    max_https smallint,
    geo_region character varying(50) DEFAULT NULL::character varying,
    geo_city character varying(50) DEFAULT NULL::character varying,
    geo_postal_code character varying(10) DEFAULT NULL::character varying,
    geo_latitude numeric(8,4) DEFAULT NULL::numeric,
    geo_longitude numeric(8,4) DEFAULT NULL::numeric,
    geo_dma_code character varying(50) DEFAULT NULL::character varying,
    geo_area_code character varying(50) DEFAULT NULL::character varying,
    geo_organisation character varying(50) DEFAULT NULL::character varying,
    geo_netspeed character varying(20) DEFAULT NULL::character varying,
    geo_continent character varying(13) DEFAULT NULL::character varying
);


--
-- TOC entry 1686 (class 1259 OID 1954920)
-- Dependencies: 2222 2223 2224 2225 2226 2227 2228 2229 2230 2231 2232 2233 2234 2235 2236 2237 2238 2239 2240 2241 2242 2243 2244 2245 2246 2247 3
-- Name: ox_data_raw_ad_impression; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_raw_ad_impression (
    viewer_id character varying(32) DEFAULT NULL::character varying,
    viewer_session_id character varying(32) DEFAULT NULL::character varying,
    date_time timestamp without time zone,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    channel character varying(255) DEFAULT NULL::character varying,
    channel_ids character varying(64) DEFAULT NULL::character varying,
    language character varying(32) DEFAULT NULL::character varying,
    ip_address character varying(16) DEFAULT NULL::character varying,
    host_name character varying(255) DEFAULT NULL::character varying,
    country character(2) DEFAULT NULL::bpchar,
    https smallint,
    domain character varying(255) DEFAULT NULL::character varying,
    page character varying(255) DEFAULT NULL::character varying,
    query character varying(255) DEFAULT NULL::character varying,
    referer character varying(255) DEFAULT NULL::character varying,
    search_term character varying(255) DEFAULT NULL::character varying,
    user_agent character varying(255) DEFAULT NULL::character varying,
    os character varying(32) DEFAULT NULL::character varying,
    browser character varying(32) DEFAULT NULL::character varying,
    max_https smallint,
    geo_region character varying(50) DEFAULT NULL::character varying,
    geo_city character varying(50) DEFAULT NULL::character varying,
    geo_postal_code character varying(10) DEFAULT NULL::character varying,
    geo_latitude numeric(8,4) DEFAULT NULL::numeric,
    geo_longitude numeric(8,4) DEFAULT NULL::numeric,
    geo_dma_code character varying(50) DEFAULT NULL::character varying,
    geo_area_code character varying(50) DEFAULT NULL::character varying,
    geo_organisation character varying(50) DEFAULT NULL::character varying,
    geo_netspeed character varying(20) DEFAULT NULL::character varying,
    geo_continent character varying(13) DEFAULT NULL::character varying
);


--
-- TOC entry 1687 (class 1259 OID 1954956)
-- Dependencies: 2248 2249 2250 2251 2252 2253 2254 2255 2256 2257 2258 2259 2260 2261 2262 3
-- Name: ox_data_raw_ad_request; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_raw_ad_request (
    viewer_id character varying(32) DEFAULT NULL::character varying,
    viewer_session_id character varying(32) DEFAULT NULL::character varying,
    date_time timestamp without time zone,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    channel character varying(255) DEFAULT NULL::character varying,
    channel_ids character varying(64) DEFAULT NULL::character varying,
    language character varying(32) DEFAULT NULL::character varying,
    ip_address character varying(16) DEFAULT NULL::character varying,
    host_name character varying(255) DEFAULT NULL::character varying,
    https smallint,
    domain character varying(255) DEFAULT NULL::character varying,
    page character varying(255) DEFAULT NULL::character varying,
    query character varying(255) DEFAULT NULL::character varying,
    referer character varying(255) DEFAULT NULL::character varying,
    search_term character varying(255) DEFAULT NULL::character varying,
    user_agent character varying(255) DEFAULT NULL::character varying,
    os character varying(32) DEFAULT NULL::character varying,
    browser character varying(32) DEFAULT NULL::character varying,
    max_https smallint
);


--
-- TOC entry 1689 (class 1259 OID 1954983)
-- Dependencies: 2264 2265 2266 2267 2268 2269 2270 2271 2272 2273 2274 2275 2276 2277 2278 2279 2280 2281 2282 2283 2284 2285 2286 2287 2288 2289 2290 3
-- Name: ox_data_raw_tracker_impression; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_raw_tracker_impression (
    server_raw_tracker_impression_id bigint NOT NULL,
    server_raw_ip character varying(16) DEFAULT ''::character varying NOT NULL,
    viewer_id character varying(32) DEFAULT ''::character varying NOT NULL,
    viewer_session_id character varying(32) DEFAULT NULL::character varying,
    date_time timestamp without time zone,
    tracker_id integer NOT NULL,
    channel character varying(255) DEFAULT NULL::character varying,
    channel_ids character varying(64) DEFAULT NULL::character varying,
    language character varying(32) DEFAULT NULL::character varying,
    ip_address character varying(16) DEFAULT NULL::character varying,
    host_name character varying(255) DEFAULT NULL::character varying,
    country character(2) DEFAULT NULL::bpchar,
    https integer,
    domain character varying(255) DEFAULT NULL::character varying,
    page character varying(255) DEFAULT NULL::character varying,
    query character varying(255) DEFAULT NULL::character varying,
    referer character varying(255) DEFAULT NULL::character varying,
    search_term character varying(255) DEFAULT NULL::character varying,
    user_agent character varying(255) DEFAULT NULL::character varying,
    os character varying(32) DEFAULT NULL::character varying,
    browser character varying(32) DEFAULT NULL::character varying,
    max_https integer,
    geo_region character varying(50) DEFAULT NULL::character varying,
    geo_city character varying(50) DEFAULT NULL::character varying,
    geo_postal_code character varying(10) DEFAULT NULL::character varying,
    geo_latitude numeric(8,4) DEFAULT NULL::numeric,
    geo_longitude numeric(8,4) DEFAULT NULL::numeric,
    geo_dma_code character varying(50) DEFAULT NULL::character varying,
    geo_area_code character varying(50) DEFAULT NULL::character varying,
    geo_organisation character varying(50) DEFAULT NULL::character varying,
    geo_netspeed character varying(20) DEFAULT NULL::character varying,
    geo_continent character varying(13) DEFAULT NULL::character varying
);


--
-- TOC entry 1690 (class 1259 OID 1955021)
-- Dependencies: 2291 2292 3
-- Name: ox_data_raw_tracker_variable_value; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_raw_tracker_variable_value (
    server_raw_tracker_impression_id bigint NOT NULL,
    server_raw_ip character varying(16) DEFAULT ''::character varying NOT NULL,
    tracker_variable_id integer NOT NULL,
    date_time timestamp without time zone,
    value character varying(50) DEFAULT NULL::character varying
);


--
-- TOC entry 1692 (class 1259 OID 1955030)
-- Dependencies: 2294 2295 2296 2297 2298 2299 2300 2301 3
-- Name: ox_data_summary_ad_hourly; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_summary_ad_hourly (
    data_summary_ad_hourly_id bigint NOT NULL,
    date_time timestamp without time zone,
    ad_id integer NOT NULL,
    creative_id integer NOT NULL,
    zone_id integer NOT NULL,
    requests integer DEFAULT 0 NOT NULL,
    impressions integer DEFAULT 0 NOT NULL,
    clicks integer DEFAULT 0 NOT NULL,
    conversions integer DEFAULT 0 NOT NULL,
    total_basket_value numeric(10,4) DEFAULT NULL::numeric,
    total_num_items integer,
    total_revenue numeric(10,4) DEFAULT NULL::numeric,
    total_cost numeric(10,4) DEFAULT NULL::numeric,
    total_techcost numeric(10,4) DEFAULT NULL::numeric,
    updated timestamp without time zone
);


--
-- TOC entry 1694 (class 1259 OID 1955049)
-- Dependencies: 2303 2304 3
-- Name: ox_data_summary_ad_zone_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_summary_ad_zone_assoc (
    data_summary_ad_zone_assoc_id bigint NOT NULL,
    operation_interval integer NOT NULL,
    operation_interval_id integer NOT NULL,
    interval_start timestamp without time zone,
    interval_end timestamp without time zone,
    ad_id integer NOT NULL,
    zone_id integer NOT NULL,
    required_impressions integer NOT NULL,
    requested_impressions integer NOT NULL,
    priority double precision NOT NULL,
    priority_factor double precision,
    priority_factor_limited smallint DEFAULT 0 NOT NULL,
    past_zone_traffic_fraction double precision,
    created timestamp without time zone,
    created_by integer NOT NULL,
    expired timestamp without time zone,
    expired_by integer,
    to_be_delivered smallint DEFAULT 1 NOT NULL
);


--
-- TOC entry 1696 (class 1259 OID 1955064)
-- Dependencies: 2306 2307 3
-- Name: ox_data_summary_channel_daily; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_summary_channel_daily (
    data_summary_channel_daily_id bigint NOT NULL,
    day date,
    channel_id integer NOT NULL,
    zone_id integer NOT NULL,
    forecast_impressions integer DEFAULT 0 NOT NULL,
    actual_impressions integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1698 (class 1259 OID 1955077)
-- Dependencies: 3
-- Name: ox_data_summary_zone_impression_history; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_data_summary_zone_impression_history (
    data_summary_zone_impression_history_id bigint NOT NULL,
    operation_interval integer NOT NULL,
    operation_interval_id integer NOT NULL,
    interval_start timestamp without time zone,
    interval_end timestamp without time zone,
    zone_id integer NOT NULL,
    forecast_impressions integer,
    actual_impressions integer,
    est smallint
);


--
-- TOC entry 1645 (class 1259 OID 1954447)
-- Dependencies: 1999 2000 2001 2002 2003 2004 3
-- Name: ox_database_action; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_database_action (
    database_action_id integer NOT NULL,
    upgrade_action_id integer DEFAULT 0,
    schema_name character varying(64) DEFAULT NULL::character varying,
    version integer NOT NULL,
    timing integer NOT NULL,
    action integer NOT NULL,
    info1 character varying(255) DEFAULT NULL::character varying,
    info2 character varying(255) DEFAULT NULL::character varying,
    tablename character varying(64) DEFAULT NULL::character varying,
    tablename_backup character varying(64) DEFAULT NULL::character varying,
    table_backup_schema text,
    updated timestamp without time zone
);


--
-- TOC entry 1699 (class 1259 OID 1955085)
-- Dependencies: 2309 3
-- Name: ox_images; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_images (
    filename character varying(128) DEFAULT ''::character varying NOT NULL,
    contents bytea NOT NULL,
    t_stamp timestamp without time zone
);


--
-- TOC entry 1700 (class 1259 OID 1955094)
-- Dependencies: 3
-- Name: ox_lb_local; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_lb_local (
    last_run integer
);


--
-- TOC entry 1702 (class 1259 OID 1955099)
-- Dependencies: 3
-- Name: ox_log_maintenance_forecasting; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_log_maintenance_forecasting (
    log_maintenance_forecasting_id integer NOT NULL,
    start_run timestamp without time zone,
    end_run timestamp without time zone,
    operation_interval integer NOT NULL,
    duration integer NOT NULL,
    updated_to timestamp without time zone
);


--
-- TOC entry 1704 (class 1259 OID 1955107)
-- Dependencies: 3
-- Name: ox_log_maintenance_priority; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_log_maintenance_priority (
    log_maintenance_priority_id integer NOT NULL,
    start_run timestamp without time zone,
    end_run timestamp without time zone,
    operation_interval integer NOT NULL,
    duration integer NOT NULL,
    run_type smallint NOT NULL,
    updated_to timestamp without time zone
);


--
-- TOC entry 1706 (class 1259 OID 1955115)
-- Dependencies: 3
-- Name: ox_log_maintenance_statistics; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_log_maintenance_statistics (
    log_maintenance_statistics_id integer NOT NULL,
    start_run timestamp without time zone,
    end_run timestamp without time zone,
    duration integer NOT NULL,
    adserver_run_type integer,
    search_run_type integer,
    tracker_run_type integer,
    updated_to timestamp without time zone
);


--
-- TOC entry 1707 (class 1259 OID 1955121)
-- Dependencies: 2313 2314 3
-- Name: ox_password_recovery; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_password_recovery (
    user_type character varying(64) DEFAULT ''::character varying NOT NULL,
    user_id integer NOT NULL,
    recovery_id character varying(64) DEFAULT ''::character varying NOT NULL,
    updated timestamp without time zone
);


--
-- TOC entry 1709 (class 1259 OID 1955132)
-- Dependencies: 3
-- Name: ox_placement_zone_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_placement_zone_assoc (
    placement_zone_assoc_id integer NOT NULL,
    zone_id integer,
    placement_id integer
);


--
-- TOC entry 1710 (class 1259 OID 1955140)
-- Dependencies: 2316 2317 2318 3
-- Name: ox_plugins_channel_delivery_assoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_plugins_channel_delivery_assoc (
    rule_id integer DEFAULT 0 NOT NULL,
    domain_id integer DEFAULT 0 NOT NULL,
    rule_order smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1712 (class 1259 OID 1955153)
-- Dependencies: 2320 3
-- Name: ox_plugins_channel_delivery_domains; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_plugins_channel_delivery_domains (
    domain_id integer NOT NULL,
    domain_name character varying(255) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 1714 (class 1259 OID 1955163)
-- Dependencies: 2322 2323 2324 3
-- Name: ox_plugins_channel_delivery_rules; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_plugins_channel_delivery_rules (
    rule_id integer NOT NULL,
    modifier character varying(100) DEFAULT ''::character varying NOT NULL,
    client character varying(100) DEFAULT ''::character varying NOT NULL,
    rule text DEFAULT ''::text NOT NULL
);


--
-- TOC entry 1716 (class 1259 OID 1955177)
-- Dependencies: 2326 2327 3
-- Name: ox_preferences; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_preferences (
    preference_id integer NOT NULL,
    preference_name character varying(64) DEFAULT ''::character varying NOT NULL,
    account_type character varying(16) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 1717 (class 1259 OID 1955188)
-- Dependencies: 2328 2329 3
-- Name: ox_session; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_session (
    sessionid character varying(32) DEFAULT ''::character varying NOT NULL,
    sessiondata text DEFAULT ''::text NOT NULL,
    lastused timestamp without time zone
);


--
-- TOC entry 1718 (class 1259 OID 1955198)
-- Dependencies: 2330 2331 2332 2333 3
-- Name: ox_targetstats; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_targetstats (
    day date,
    campaignid integer DEFAULT 0 NOT NULL,
    target integer DEFAULT 0 NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    modified smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1720 (class 1259 OID 1955207)
-- Dependencies: 2335 2336 2337 2338 2339 3
-- Name: ox_tracker_append; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_tracker_append (
    tracker_append_id integer NOT NULL,
    tracker_id integer DEFAULT 0 NOT NULL,
    rank integer DEFAULT 0 NOT NULL,
    tagcode text DEFAULT ''::text NOT NULL,
    paused boolean DEFAULT false NOT NULL,
    autotrack boolean DEFAULT false NOT NULL
);


--
-- TOC entry 1722 (class 1259 OID 1955224)
-- Dependencies: 2341 2342 2343 2344 2345 2346 2347 2348 2349 2350 2351 3
-- Name: ox_trackers; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_trackers (
    trackerid integer NOT NULL,
    trackername character varying(255) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    clientid integer DEFAULT 0 NOT NULL,
    viewwindow integer DEFAULT 0 NOT NULL,
    clickwindow integer DEFAULT 0 NOT NULL,
    blockwindow integer DEFAULT 0 NOT NULL,
    status smallint DEFAULT 4 NOT NULL,
    type smallint DEFAULT 1 NOT NULL,
    linkcampaigns boolean DEFAULT false NOT NULL,
    variablemethod text DEFAULT 'default'::text NOT NULL,
    appendcode text DEFAULT ''::text NOT NULL,
    updated timestamp without time zone
);


--
-- TOC entry 1647 (class 1259 OID 1954467)
-- Dependencies: 2006 2007 2008 2009 2010 2011 3
-- Name: ox_upgrade_action; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_upgrade_action (
    upgrade_action_id integer NOT NULL,
    upgrade_name character varying(128) DEFAULT NULL::character varying,
    version_to character varying(64) DEFAULT ''::character varying NOT NULL,
    version_from character varying(64) DEFAULT NULL::character varying,
    action integer NOT NULL,
    description character varying(255) DEFAULT NULL::character varying,
    logfile character varying(128) DEFAULT NULL::character varying,
    confbackup character varying(128) DEFAULT NULL::character varying,
    updated timestamp without time zone
);


--
-- TOC entry 1724 (class 1259 OID 1955247)
-- Dependencies: 2353 2354 2355 2356 3
-- Name: ox_userlog; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_userlog (
    userlogid integer NOT NULL,
    "timestamp" integer DEFAULT 0 NOT NULL,
    usertype smallint DEFAULT 0 NOT NULL,
    userid integer DEFAULT 0 NOT NULL,
    action integer DEFAULT 0 NOT NULL,
    object integer,
    details text
);


--
-- TOC entry 1726 (class 1259 OID 1955262)
-- Dependencies: 2358 2359 2360 2361 2362 2363 3
-- Name: ox_users; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_users (
    user_id integer NOT NULL,
    contact_name character varying(255) DEFAULT ''::character varying NOT NULL,
    email_address character varying(64) DEFAULT ''::character varying NOT NULL,
    username character varying(64) DEFAULT NULL::character varying,
    password character varying(64) DEFAULT NULL::character varying,
    language character varying(5) DEFAULT NULL::character varying,
    default_account_id integer,
    comments text,
    active smallint DEFAULT 1 NOT NULL,
    sso_user_id integer,
    date_created timestamp without time zone,
    date_last_login timestamp without time zone,
    email_updated timestamp without time zone
);


--
-- TOC entry 1727 (class 1259 OID 1955281)
-- Dependencies: 3
-- Name: ox_variable_publisher; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_variable_publisher (
    variable_id integer NOT NULL,
    publisher_id integer NOT NULL,
    visible smallint NOT NULL
);


--
-- TOC entry 1729 (class 1259 OID 1955288)
-- Dependencies: 2365 2366 2367 2368 2369 2370 2371 2372 2373 3
-- Name: ox_variables; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_variables (
    variableid integer NOT NULL,
    trackerid integer DEFAULT 0 NOT NULL,
    name character varying(250) DEFAULT ''::character varying NOT NULL,
    description character varying(250) DEFAULT NULL::character varying,
    datatype text DEFAULT 'numeric'::text NOT NULL,
    purpose text,
    reject_if_empty smallint DEFAULT 0 NOT NULL,
    is_unique integer DEFAULT 0 NOT NULL,
    unique_window integer DEFAULT 0 NOT NULL,
    variablecode character varying(255) DEFAULT ''::character varying NOT NULL,
    hidden boolean DEFAULT false NOT NULL,
    updated timestamp without time zone
);


--
-- TOC entry 1731 (class 1259 OID 1955310)
-- Dependencies: 2375 2376 2377 2378 2379 2380 2381 2382 2383 2384 2385 2386 2387 2388 2389 2390 2391 2392 2393 2394 2395 2396 2397 2398 3
-- Name: ox_zones; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_zones (
    zoneid integer NOT NULL,
    affiliateid integer,
    zonename character varying(245) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    delivery smallint DEFAULT 0 NOT NULL,
    zonetype smallint DEFAULT 0 NOT NULL,
    category text DEFAULT ''::text NOT NULL,
    width smallint DEFAULT 0 NOT NULL,
    height smallint DEFAULT 0 NOT NULL,
    ad_selection text DEFAULT ''::text NOT NULL,
    chain text DEFAULT ''::text NOT NULL,
    prepend text DEFAULT ''::text NOT NULL,
    append text DEFAULT ''::text NOT NULL,
    appendtype smallint DEFAULT 0 NOT NULL,
    forceappend boolean DEFAULT false,
    inventory_forecast_type smallint DEFAULT 0 NOT NULL,
    comments text,
    cost numeric(10,4) DEFAULT NULL::numeric,
    cost_type smallint,
    cost_variable_id character varying(255) DEFAULT NULL::character varying,
    technology_cost numeric(10,4) DEFAULT NULL::numeric,
    technology_cost_type smallint,
    updated timestamp without time zone,
    block integer DEFAULT 0 NOT NULL,
    capping integer DEFAULT 0 NOT NULL,
    session_capping integer DEFAULT 0 NOT NULL,
    what text DEFAULT ''::text NOT NULL,
    as_zone_id integer,
    is_in_ad_direct smallint DEFAULT 0 NOT NULL,
    rate numeric(19,2) DEFAULT NULL::numeric,
    pricing character varying(50) DEFAULT 'CPM'::character varying NOT NULL
);


--
-- TOC entry 32 (class 1255 OID 1954433)
-- Dependencies: 3 472
-- Name: concat(text, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION concat(text, text) RETURNS text
    AS $_$ BEGIN RETURN $1 || $2;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 33 (class 1255 OID 1954434)
-- Dependencies: 3 472
-- Name: concat(anyelement); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION concat(anyelement) RETURNS text
    AS $_$ BEGIN RETURN $1::text;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 20 (class 1255 OID 1954421)
-- Dependencies: 3 472
-- Name: date_add(timestamp with time zone, interval); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION date_add(timestamp with time zone, interval) RETURNS timestamp with time zone
    AS $_$ BEGIN RETURN $1 + $2;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 21 (class 1255 OID 1954422)
-- Dependencies: 472 3
-- Name: date_format(timestamp with time zone, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION date_format(timestamp with time zone, text) RETURNS text
    AS $_$ DECLARE f text; r text[][] = ARRAY[['%Y','YYYY'],['%m','MM'],['%d','DD'],['%H','HH24'],['%i','MI'],['%S','SS'],['%k','FMHH24']]; i int4;BEGIN f := $2; FOR i IN 1..array_upper(r, 1) LOOP  f := replace(f, r[i][1], r[i][2]); END LOOP; RETURN to_char($1, f);END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 22 (class 1255 OID 1954423)
-- Dependencies: 472 3
-- Name: dayofweek(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION dayofweek(timestamp with time zone) RETURNS integer
    AS $_$ DECLARE i int4;BEGIN i = date_part('dow', $1); RETURN i + 1;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 23 (class 1255 OID 1954424)
-- Dependencies: 472 3
-- Name: find_in_set(integer, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION find_in_set(integer, text) RETURNS integer
    AS $_$ DECLARE a varchar[]; i int4;BEGIN IF LENGTH($2) > 0 THEN   a := string_to_array($2, ',');   FOR i IN 1..array_upper(a, 1) LOOP     IF $1 = a[i]::integer THEN       RETURN i;     END IF;  END LOOP; END IF; RETURN 0;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 29 (class 1255 OID 1954430)
-- Dependencies: 3 472
-- Name: hour(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION hour(timestamp with time zone) RETURNS integer
    AS $_$ BEGIN RETURN date_part('hour', $1)::integer;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 24 (class 1255 OID 1954425)
-- Dependencies: 3 472
-- Name: if(boolean, integer, integer); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION if(boolean, integer, integer) RETURNS integer
    AS $_$ BEGIN IF ($1) THEN  RETURN $2; END IF; RETURN $3;END;$_$
    LANGUAGE plpgsql IMMUTABLE;


--
-- TOC entry 25 (class 1255 OID 1954426)
-- Dependencies: 472 3
-- Name: if(boolean, character varying, integer); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION if(boolean, character varying, integer) RETURNS integer
    AS $_$ BEGIN IF ($1) THEN  RETURN $2; END IF; RETURN $3;END;$_$
    LANGUAGE plpgsql IMMUTABLE;


--
-- TOC entry 26 (class 1255 OID 1954427)
-- Dependencies: 472 3
-- Name: if(boolean, character varying, character varying); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION if(boolean, character varying, character varying) RETURNS character varying
    AS $_$ BEGIN IF ($1) THEN  RETURN $2; END IF; RETURN $3;END;$_$
    LANGUAGE plpgsql IMMUTABLE;


--
-- TOC entry 27 (class 1255 OID 1954428)
-- Dependencies: 472 3
-- Name: if(boolean, timestamp with time zone, timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION if(boolean, timestamp with time zone, timestamp with time zone) RETURNS timestamp with time zone
    AS $_$ BEGIN IF ($1) THEN  RETURN $2; END IF; RETURN $3;END;$_$
    LANGUAGE plpgsql IMMUTABLE;


--
-- TOC entry 28 (class 1255 OID 1954429)
-- Dependencies: 3 472
-- Name: ifnull(numeric, integer); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION ifnull(numeric, integer) RETURNS integer
    AS $_$ BEGIN IF ($1 IS NULL) THEN  RETURN $2; END IF; RETURN $1::integer;END;$_$
    LANGUAGE plpgsql IMMUTABLE;


--
-- TOC entry 30 (class 1255 OID 1954431)
-- Dependencies: 472 3
-- Name: to_days(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION to_days(timestamp with time zone) RETURNS integer
    AS $_$ BEGIN RETURN round(date_part('epoch', $1::date) / 86400)::int4 + 719528;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 31 (class 1255 OID 1954432)
-- Dependencies: 472 3
-- Name: unix_timestamp(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION unix_timestamp(timestamp with time zone) RETURNS integer
    AS $_$ BEGIN RETURN date_part('epoch', $1)::int;END;$_$
    LANGUAGE plpgsql IMMUTABLE STRICT;


--
-- TOC entry 1651 (class 1259 OID 1954504)
-- Dependencies: 1652 3
-- Name: ox_accounts_account_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_accounts_account_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2643 (class 0 OID 0)
-- Dependencies: 1651
-- Name: ox_accounts_account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_accounts_account_id_seq OWNED BY ox_accounts.account_id;


--
-- TOC entry 2644 (class 0 OID 0)
-- Dependencies: 1651
-- Name: ox_accounts_account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_accounts_account_id_seq', 3, true);


--
-- TOC entry 1655 (class 1259 OID 1954547)
-- Dependencies: 1656 3
-- Name: ox_ad_category_assoc_ad_category_assoc_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_ad_category_assoc_ad_category_assoc_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2645 (class 0 OID 0)
-- Dependencies: 1655
-- Name: ox_ad_category_assoc_ad_category_assoc_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_ad_category_assoc_ad_category_assoc_id_seq OWNED BY ox_ad_category_assoc.ad_category_assoc_id;


--
-- TOC entry 2646 (class 0 OID 0)
-- Dependencies: 1655
-- Name: ox_ad_category_assoc_ad_category_assoc_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_ad_category_assoc_ad_category_assoc_id_seq', 1, false);


--
-- TOC entry 1657 (class 1259 OID 1954555)
-- Dependencies: 3 1658
-- Name: ox_ad_zone_assoc_ad_zone_assoc_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_ad_zone_assoc_ad_zone_assoc_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2647 (class 0 OID 0)
-- Dependencies: 1657
-- Name: ox_ad_zone_assoc_ad_zone_assoc_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_ad_zone_assoc_ad_zone_assoc_id_seq OWNED BY ox_ad_zone_assoc.ad_zone_assoc_id;


--
-- TOC entry 2648 (class 0 OID 0)
-- Dependencies: 1657
-- Name: ox_ad_zone_assoc_ad_zone_assoc_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_ad_zone_assoc_ad_zone_assoc_id_seq', 8, true);


--
-- TOC entry 1659 (class 1259 OID 1954569)
-- Dependencies: 1660 3
-- Name: ox_affiliates_affiliateid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_affiliates_affiliateid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2649 (class 0 OID 0)
-- Dependencies: 1659
-- Name: ox_affiliates_affiliateid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_affiliates_affiliateid_seq OWNED BY ox_affiliates.affiliateid;


--
-- TOC entry 2650 (class 0 OID 0)
-- Dependencies: 1659
-- Name: ox_affiliates_affiliateid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_affiliates_affiliateid_seq', 1, false);


--
-- TOC entry 1662 (class 1259 OID 1954610)
-- Dependencies: 3 1663
-- Name: ox_agency_agencyid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_agency_agencyid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2651 (class 0 OID 0)
-- Dependencies: 1662
-- Name: ox_agency_agencyid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_agency_agencyid_seq OWNED BY ox_agency.agencyid;


--
-- TOC entry 2652 (class 0 OID 0)
-- Dependencies: 1662
-- Name: ox_agency_agencyid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_agency_agencyid_seq', 1, true);


--
-- TOC entry 1665 (class 1259 OID 1954638)
-- Dependencies: 3 1666
-- Name: ox_audit_auditid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_audit_auditid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2653 (class 0 OID 0)
-- Dependencies: 1665
-- Name: ox_audit_auditid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_audit_auditid_seq OWNED BY ox_audit.auditid;


--
-- TOC entry 2654 (class 0 OID 0)
-- Dependencies: 1665
-- Name: ox_audit_auditid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_audit_auditid_seq', 263, true);


--
-- TOC entry 1667 (class 1259 OID 1954662)
-- Dependencies: 3 1668
-- Name: ox_banners_bannerid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_banners_bannerid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2655 (class 0 OID 0)
-- Dependencies: 1667
-- Name: ox_banners_bannerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_banners_bannerid_seq OWNED BY ox_banners.bannerid;


--
-- TOC entry 2656 (class 0 OID 0)
-- Dependencies: 1667
-- Name: ox_banners_bannerid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_banners_bannerid_seq', 3, true);


--
-- TOC entry 1669 (class 1259 OID 1954709)
-- Dependencies: 3 1670
-- Name: ox_campaigns_campaignid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_campaigns_campaignid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2657 (class 0 OID 0)
-- Dependencies: 1669
-- Name: ox_campaigns_campaignid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_campaigns_campaignid_seq OWNED BY ox_campaigns.campaignid;


--
-- TOC entry 2658 (class 0 OID 0)
-- Dependencies: 1669
-- Name: ox_campaigns_campaignid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_campaigns_campaignid_seq', 3, true);


--
-- TOC entry 1671 (class 1259 OID 1954742)
-- Dependencies: 3 1672
-- Name: ox_campaigns_trackers_campaign_trackerid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_campaigns_trackers_campaign_trackerid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2659 (class 0 OID 0)
-- Dependencies: 1671
-- Name: ox_campaigns_trackers_campaign_trackerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_campaigns_trackers_campaign_trackerid_seq OWNED BY ox_campaigns_trackers.campaign_trackerid;


--
-- TOC entry 2660 (class 0 OID 0)
-- Dependencies: 1671
-- Name: ox_campaigns_trackers_campaign_trackerid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_campaigns_trackers_campaign_trackerid_seq', 1, false);


--
-- TOC entry 1673 (class 1259 OID 1954757)
-- Dependencies: 1674 3
-- Name: ox_category_category_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_category_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2661 (class 0 OID 0)
-- Dependencies: 1673
-- Name: ox_category_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_category_category_id_seq OWNED BY ox_category.category_id;


--
-- TOC entry 2662 (class 0 OID 0)
-- Dependencies: 1673
-- Name: ox_category_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_category_category_id_seq', 1, false);


--
-- TOC entry 1675 (class 1259 OID 1954766)
-- Dependencies: 3 1676
-- Name: ox_channel_channelid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_channel_channelid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2663 (class 0 OID 0)
-- Dependencies: 1675
-- Name: ox_channel_channelid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_channel_channelid_seq OWNED BY ox_channel.channelid;


--
-- TOC entry 2664 (class 0 OID 0)
-- Dependencies: 1675
-- Name: ox_channel_channelid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_channel_channelid_seq', 1, true);


--
-- TOC entry 1677 (class 1259 OID 1954782)
-- Dependencies: 1678 3
-- Name: ox_clients_clientid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_clients_clientid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2665 (class 0 OID 0)
-- Dependencies: 1677
-- Name: ox_clients_clientid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_clients_clientid_seq OWNED BY ox_clients.clientid;


--
-- TOC entry 2666 (class 0 OID 0)
-- Dependencies: 1677
-- Name: ox_clients_clientid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_clients_clientid_seq', 1, true);


--
-- TOC entry 1681 (class 1259 OID 1954823)
-- Dependencies: 1682 3
-- Name: ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2667 (class 0 OID 0)
-- Dependencies: 1681
-- Name: ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq OWNED BY ox_data_intermediate_ad_connection.data_intermediate_ad_connection_id;


--
-- TOC entry 2668 (class 0 OID 0)
-- Dependencies: 1681
-- Name: ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq', 1, false);


--
-- TOC entry 1679 (class 1259 OID 1954805)
-- Dependencies: 3 1680
-- Name: ox_data_intermediate_ad_data_intermediate_ad_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_intermediate_ad_data_intermediate_ad_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2669 (class 0 OID 0)
-- Dependencies: 1679
-- Name: ox_data_intermediate_ad_data_intermediate_ad_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_intermediate_ad_data_intermediate_ad_id_seq OWNED BY ox_data_intermediate_ad.data_intermediate_ad_id;


--
-- TOC entry 2670 (class 0 OID 0)
-- Dependencies: 1679
-- Name: ox_data_intermediate_ad_data_intermediate_ad_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_intermediate_ad_data_intermediate_ad_id_seq', 1, false);


--
-- TOC entry 1683 (class 1259 OID 1954872)
-- Dependencies: 1684 3
-- Name: ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2671 (class 0 OID 0)
-- Dependencies: 1683
-- Name: ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq OWNED BY ox_data_intermediate_ad_variable_value.data_intermediate_ad_variable_value_id;


--
-- TOC entry 2672 (class 0 OID 0)
-- Dependencies: 1683
-- Name: ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq', 1, false);


--
-- TOC entry 1688 (class 1259 OID 1954981)
-- Dependencies: 3 1689
-- Name: ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2673 (class 0 OID 0)
-- Dependencies: 1688
-- Name: ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq OWNED BY ox_data_raw_tracker_impression.server_raw_tracker_impression_id;


--
-- TOC entry 2674 (class 0 OID 0)
-- Dependencies: 1688
-- Name: ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq', 1, false);


--
-- TOC entry 1691 (class 1259 OID 1955028)
-- Dependencies: 3 1692
-- Name: ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2675 (class 0 OID 0)
-- Dependencies: 1691
-- Name: ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq OWNED BY ox_data_summary_ad_hourly.data_summary_ad_hourly_id;


--
-- TOC entry 2676 (class 0 OID 0)
-- Dependencies: 1691
-- Name: ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq', 1, false);


--
-- TOC entry 1693 (class 1259 OID 1955047)
-- Dependencies: 1694 3
-- Name: ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2677 (class 0 OID 0)
-- Dependencies: 1693
-- Name: ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq OWNED BY ox_data_summary_ad_zone_assoc.data_summary_ad_zone_assoc_id;


--
-- TOC entry 2678 (class 0 OID 0)
-- Dependencies: 1693
-- Name: ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq', 1, false);


--
-- TOC entry 1695 (class 1259 OID 1955062)
-- Dependencies: 1696 3
-- Name: ox_data_summary_channel_daily_data_summary_channel_daily_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_summary_channel_daily_data_summary_channel_daily_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2679 (class 0 OID 0)
-- Dependencies: 1695
-- Name: ox_data_summary_channel_daily_data_summary_channel_daily_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_summary_channel_daily_data_summary_channel_daily_id_seq OWNED BY ox_data_summary_channel_daily.data_summary_channel_daily_id;


--
-- TOC entry 2680 (class 0 OID 0)
-- Dependencies: 1695
-- Name: ox_data_summary_channel_daily_data_summary_channel_daily_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_summary_channel_daily_data_summary_channel_daily_id_seq', 1, false);


--
-- TOC entry 1697 (class 1259 OID 1955075)
-- Dependencies: 1698 3
-- Name: ox_data_summary_zone_impressi_data_summary_zone_impression__seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_data_summary_zone_impressi_data_summary_zone_impression__seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2681 (class 0 OID 0)
-- Dependencies: 1697
-- Name: ox_data_summary_zone_impressi_data_summary_zone_impression__seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_data_summary_zone_impressi_data_summary_zone_impression__seq OWNED BY ox_data_summary_zone_impression_history.data_summary_zone_impression_history_id;


--
-- TOC entry 2682 (class 0 OID 0)
-- Dependencies: 1697
-- Name: ox_data_summary_zone_impressi_data_summary_zone_impression__seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_data_summary_zone_impressi_data_summary_zone_impression__seq', 1, false);


--
-- TOC entry 1644 (class 1259 OID 1954445)
-- Dependencies: 1645 3
-- Name: ox_database_action_database_action_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_database_action_database_action_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2683 (class 0 OID 0)
-- Dependencies: 1644
-- Name: ox_database_action_database_action_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_database_action_database_action_id_seq OWNED BY ox_database_action.database_action_id;


--
-- TOC entry 2684 (class 0 OID 0)
-- Dependencies: 1644
-- Name: ox_database_action_database_action_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_database_action_database_action_id_seq', 1, false);


--
-- TOC entry 1701 (class 1259 OID 1955097)
-- Dependencies: 1702 3
-- Name: ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2685 (class 0 OID 0)
-- Dependencies: 1701
-- Name: ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq OWNED BY ox_log_maintenance_forecasting.log_maintenance_forecasting_id;


--
-- TOC entry 2686 (class 0 OID 0)
-- Dependencies: 1701
-- Name: ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq', 1, false);


--
-- TOC entry 1703 (class 1259 OID 1955105)
-- Dependencies: 3 1704
-- Name: ox_log_maintenance_priority_log_maintenance_priority_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_log_maintenance_priority_log_maintenance_priority_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2687 (class 0 OID 0)
-- Dependencies: 1703
-- Name: ox_log_maintenance_priority_log_maintenance_priority_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_log_maintenance_priority_log_maintenance_priority_id_seq OWNED BY ox_log_maintenance_priority.log_maintenance_priority_id;


--
-- TOC entry 2688 (class 0 OID 0)
-- Dependencies: 1703
-- Name: ox_log_maintenance_priority_log_maintenance_priority_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_log_maintenance_priority_log_maintenance_priority_id_seq', 1, false);


--
-- TOC entry 1705 (class 1259 OID 1955113)
-- Dependencies: 3 1706
-- Name: ox_log_maintenance_statistics_log_maintenance_statistics_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_log_maintenance_statistics_log_maintenance_statistics_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2689 (class 0 OID 0)
-- Dependencies: 1705
-- Name: ox_log_maintenance_statistics_log_maintenance_statistics_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_log_maintenance_statistics_log_maintenance_statistics_id_seq OWNED BY ox_log_maintenance_statistics.log_maintenance_statistics_id;


--
-- TOC entry 2690 (class 0 OID 0)
-- Dependencies: 1705
-- Name: ox_log_maintenance_statistics_log_maintenance_statistics_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_log_maintenance_statistics_log_maintenance_statistics_id_seq', 1, false);


--
-- TOC entry 1708 (class 1259 OID 1955130)
-- Dependencies: 3 1709
-- Name: ox_placement_zone_assoc_placement_zone_assoc_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_placement_zone_assoc_placement_zone_assoc_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2691 (class 0 OID 0)
-- Dependencies: 1708
-- Name: ox_placement_zone_assoc_placement_zone_assoc_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_placement_zone_assoc_placement_zone_assoc_id_seq OWNED BY ox_placement_zone_assoc.placement_zone_assoc_id;


--
-- TOC entry 2692 (class 0 OID 0)
-- Dependencies: 1708
-- Name: ox_placement_zone_assoc_placement_zone_assoc_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_placement_zone_assoc_placement_zone_assoc_id_seq', 4, true);


--
-- TOC entry 1711 (class 1259 OID 1955151)
-- Dependencies: 3 1712
-- Name: ox_plugins_channel_delivery_domains_domain_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_plugins_channel_delivery_domains_domain_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2693 (class 0 OID 0)
-- Dependencies: 1711
-- Name: ox_plugins_channel_delivery_domains_domain_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_plugins_channel_delivery_domains_domain_id_seq OWNED BY ox_plugins_channel_delivery_domains.domain_id;


--
-- TOC entry 2694 (class 0 OID 0)
-- Dependencies: 1711
-- Name: ox_plugins_channel_delivery_domains_domain_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_plugins_channel_delivery_domains_domain_id_seq', 1, false);


--
-- TOC entry 1713 (class 1259 OID 1955161)
-- Dependencies: 1714 3
-- Name: ox_plugins_channel_delivery_rules_rule_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_plugins_channel_delivery_rules_rule_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2695 (class 0 OID 0)
-- Dependencies: 1713
-- Name: ox_plugins_channel_delivery_rules_rule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_plugins_channel_delivery_rules_rule_id_seq OWNED BY ox_plugins_channel_delivery_rules.rule_id;


--
-- TOC entry 2696 (class 0 OID 0)
-- Dependencies: 1713
-- Name: ox_plugins_channel_delivery_rules_rule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_plugins_channel_delivery_rules_rule_id_seq', 1, false);


--
-- TOC entry 1715 (class 1259 OID 1955175)
-- Dependencies: 1716 3
-- Name: ox_preferences_preference_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_preferences_preference_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2697 (class 0 OID 0)
-- Dependencies: 1715
-- Name: ox_preferences_preference_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_preferences_preference_id_seq OWNED BY ox_preferences.preference_id;


--
-- TOC entry 2698 (class 0 OID 0)
-- Dependencies: 1715
-- Name: ox_preferences_preference_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_preferences_preference_id_seq', 116, true);


--
-- TOC entry 1719 (class 1259 OID 1955205)
-- Dependencies: 3 1720
-- Name: ox_tracker_append_tracker_append_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_tracker_append_tracker_append_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2699 (class 0 OID 0)
-- Dependencies: 1719
-- Name: ox_tracker_append_tracker_append_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_tracker_append_tracker_append_id_seq OWNED BY ox_tracker_append.tracker_append_id;


--
-- TOC entry 2700 (class 0 OID 0)
-- Dependencies: 1719
-- Name: ox_tracker_append_tracker_append_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_tracker_append_tracker_append_id_seq', 1, false);


--
-- TOC entry 1721 (class 1259 OID 1955222)
-- Dependencies: 1722 3
-- Name: ox_trackers_trackerid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_trackers_trackerid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2701 (class 0 OID 0)
-- Dependencies: 1721
-- Name: ox_trackers_trackerid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_trackers_trackerid_seq OWNED BY ox_trackers.trackerid;


--
-- TOC entry 2702 (class 0 OID 0)
-- Dependencies: 1721
-- Name: ox_trackers_trackerid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_trackers_trackerid_seq', 1, true);


--
-- TOC entry 1646 (class 1259 OID 1954465)
-- Dependencies: 3 1647
-- Name: ox_upgrade_action_upgrade_action_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_upgrade_action_upgrade_action_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2703 (class 0 OID 0)
-- Dependencies: 1646
-- Name: ox_upgrade_action_upgrade_action_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_upgrade_action_upgrade_action_id_seq OWNED BY ox_upgrade_action.upgrade_action_id;


--
-- TOC entry 2704 (class 0 OID 0)
-- Dependencies: 1646
-- Name: ox_upgrade_action_upgrade_action_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_upgrade_action_upgrade_action_id_seq', 1, true);


--
-- TOC entry 1723 (class 1259 OID 1955245)
-- Dependencies: 1724 3
-- Name: ox_userlog_userlogid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_userlog_userlogid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2705 (class 0 OID 0)
-- Dependencies: 1723
-- Name: ox_userlog_userlogid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_userlog_userlogid_seq OWNED BY ox_userlog.userlogid;


--
-- TOC entry 2706 (class 0 OID 0)
-- Dependencies: 1723
-- Name: ox_userlog_userlogid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_userlog_userlogid_seq', 1, false);


--
-- TOC entry 1725 (class 1259 OID 1955260)
-- Dependencies: 1726 3
-- Name: ox_users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_users_user_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2707 (class 0 OID 0)
-- Dependencies: 1725
-- Name: ox_users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_users_user_id_seq OWNED BY ox_users.user_id;


--
-- TOC entry 2708 (class 0 OID 0)
-- Dependencies: 1725
-- Name: ox_users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_users_user_id_seq', 1, true);


--
-- TOC entry 1728 (class 1259 OID 1955286)
-- Dependencies: 1729 3
-- Name: ox_variables_variableid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_variables_variableid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2709 (class 0 OID 0)
-- Dependencies: 1728
-- Name: ox_variables_variableid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_variables_variableid_seq OWNED BY ox_variables.variableid;


--
-- TOC entry 2710 (class 0 OID 0)
-- Dependencies: 1728
-- Name: ox_variables_variableid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_variables_variableid_seq', 2, true);


--
-- TOC entry 1730 (class 1259 OID 1955308)
-- Dependencies: 3 1731
-- Name: ox_zones_zoneid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_zones_zoneid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2711 (class 0 OID 0)
-- Dependencies: 1730
-- Name: ox_zones_zoneid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE ox_zones_zoneid_seq OWNED BY ox_zones.zoneid;


--
-- TOC entry 2712 (class 0 OID 0)
-- Dependencies: 1730
-- Name: ox_zones_zoneid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_zones_zoneid_seq', 2, true);


--
-- TOC entry 2014 (class 2604 OID 1954509)
-- Dependencies: 1652 1651 1652
-- Name: account_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_accounts ALTER COLUMN account_id SET DEFAULT nextval('ox_accounts_account_id_seq'::regclass);


--
-- TOC entry 2031 (class 2604 OID 1954552)
-- Dependencies: 1655 1656 1656
-- Name: ad_category_assoc_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_ad_category_assoc ALTER COLUMN ad_category_assoc_id SET DEFAULT nextval('ox_ad_category_assoc_ad_category_assoc_id_seq'::regclass);


--
-- TOC entry 2032 (class 2604 OID 1954560)
-- Dependencies: 1657 1658 1658
-- Name: ad_zone_assoc_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_ad_zone_assoc ALTER COLUMN ad_zone_assoc_id SET DEFAULT nextval('ox_ad_zone_assoc_ad_zone_assoc_id_seq'::regclass);


--
-- TOC entry 2037 (class 2604 OID 1954574)
-- Dependencies: 1660 1659 1660
-- Name: affiliateid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_affiliates ALTER COLUMN affiliateid SET DEFAULT nextval('ox_affiliates_affiliateid_seq'::regclass);


--
-- TOC entry 2057 (class 2604 OID 1954615)
-- Dependencies: 1663 1662 1663
-- Name: agencyid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_agency ALTER COLUMN agencyid SET DEFAULT nextval('ox_agency_agencyid_seq'::regclass);


--
-- TOC entry 2065 (class 2604 OID 1954643)
-- Dependencies: 1666 1665 1666
-- Name: auditid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_audit ALTER COLUMN auditid SET DEFAULT nextval('ox_audit_auditid_seq'::regclass);


--
-- TOC entry 2071 (class 2604 OID 1954667)
-- Dependencies: 1668 1667 1668
-- Name: bannerid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_banners ALTER COLUMN bannerid SET DEFAULT nextval('ox_banners_bannerid_seq'::regclass);


--
-- TOC entry 2107 (class 2604 OID 1954714)
-- Dependencies: 1669 1670 1670
-- Name: campaignid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_campaigns ALTER COLUMN campaignid SET DEFAULT nextval('ox_campaigns_campaignid_seq'::regclass);


--
-- TOC entry 2129 (class 2604 OID 1954747)
-- Dependencies: 1671 1672 1672
-- Name: campaign_trackerid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_campaigns_trackers ALTER COLUMN campaign_trackerid SET DEFAULT nextval('ox_campaigns_trackers_campaign_trackerid_seq'::regclass);


--
-- TOC entry 2135 (class 2604 OID 1954762)
-- Dependencies: 1673 1674 1674
-- Name: category_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_category ALTER COLUMN category_id SET DEFAULT nextval('ox_category_category_id_seq'::regclass);


--
-- TOC entry 2137 (class 2604 OID 1954771)
-- Dependencies: 1676 1675 1676
-- Name: channelid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_channel ALTER COLUMN channelid SET DEFAULT nextval('ox_channel_channelid_seq'::regclass);


--
-- TOC entry 2143 (class 2604 OID 1954787)
-- Dependencies: 1678 1677 1678
-- Name: clientid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_clients ALTER COLUMN clientid SET DEFAULT nextval('ox_clients_clientid_seq'::regclass);


--
-- TOC entry 2153 (class 2604 OID 1954810)
-- Dependencies: 1679 1680 1680
-- Name: data_intermediate_ad_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_intermediate_ad ALTER COLUMN data_intermediate_ad_id SET DEFAULT nextval('ox_data_intermediate_ad_data_intermediate_ad_id_seq'::regclass);


--
-- TOC entry 2160 (class 2604 OID 1954828)
-- Dependencies: 1682 1681 1682
-- Name: data_intermediate_ad_connection_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_intermediate_ad_connection ALTER COLUMN data_intermediate_ad_connection_id SET DEFAULT nextval('ox_data_intermediate_ad_conne_data_intermediate_ad_connecti_seq'::regclass);


--
-- TOC entry 2194 (class 2604 OID 1954877)
-- Dependencies: 1684 1683 1684
-- Name: data_intermediate_ad_variable_value_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_intermediate_ad_variable_value ALTER COLUMN data_intermediate_ad_variable_value_id SET DEFAULT nextval('ox_data_intermediate_ad_varia_data_intermediate_ad_variable_seq'::regclass);


--
-- TOC entry 2263 (class 2604 OID 1954986)
-- Dependencies: 1689 1688 1689
-- Name: server_raw_tracker_impression_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_raw_tracker_impression ALTER COLUMN server_raw_tracker_impression_id SET DEFAULT nextval('ox_data_raw_tracker_impressio_server_raw_tracker_impression_seq'::regclass);


--
-- TOC entry 2293 (class 2604 OID 1955033)
-- Dependencies: 1692 1691 1692
-- Name: data_summary_ad_hourly_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_summary_ad_hourly ALTER COLUMN data_summary_ad_hourly_id SET DEFAULT nextval('ox_data_summary_ad_hourly_data_summary_ad_hourly_id_seq'::regclass);


--
-- TOC entry 2302 (class 2604 OID 1955052)
-- Dependencies: 1694 1693 1694
-- Name: data_summary_ad_zone_assoc_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_summary_ad_zone_assoc ALTER COLUMN data_summary_ad_zone_assoc_id SET DEFAULT nextval('ox_data_summary_ad_zone_assoc_data_summary_ad_zone_assoc_id_seq'::regclass);


--
-- TOC entry 2305 (class 2604 OID 1955067)
-- Dependencies: 1696 1695 1696
-- Name: data_summary_channel_daily_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_summary_channel_daily ALTER COLUMN data_summary_channel_daily_id SET DEFAULT nextval('ox_data_summary_channel_daily_data_summary_channel_daily_id_seq'::regclass);


--
-- TOC entry 2308 (class 2604 OID 1955080)
-- Dependencies: 1698 1697 1698
-- Name: data_summary_zone_impression_history_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_data_summary_zone_impression_history ALTER COLUMN data_summary_zone_impression_history_id SET DEFAULT nextval('ox_data_summary_zone_impressi_data_summary_zone_impression__seq'::regclass);


--
-- TOC entry 1998 (class 2604 OID 1954450)
-- Dependencies: 1645 1644 1645
-- Name: database_action_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_database_action ALTER COLUMN database_action_id SET DEFAULT nextval('ox_database_action_database_action_id_seq'::regclass);


--
-- TOC entry 2310 (class 2604 OID 1955102)
-- Dependencies: 1701 1702 1702
-- Name: log_maintenance_forecasting_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_log_maintenance_forecasting ALTER COLUMN log_maintenance_forecasting_id SET DEFAULT nextval('ox_log_maintenance_forecastin_log_maintenance_forecasting_i_seq'::regclass);


--
-- TOC entry 2311 (class 2604 OID 1955110)
-- Dependencies: 1704 1703 1704
-- Name: log_maintenance_priority_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_log_maintenance_priority ALTER COLUMN log_maintenance_priority_id SET DEFAULT nextval('ox_log_maintenance_priority_log_maintenance_priority_id_seq'::regclass);


--
-- TOC entry 2312 (class 2604 OID 1955118)
-- Dependencies: 1706 1705 1706
-- Name: log_maintenance_statistics_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_log_maintenance_statistics ALTER COLUMN log_maintenance_statistics_id SET DEFAULT nextval('ox_log_maintenance_statistics_log_maintenance_statistics_id_seq'::regclass);


--
-- TOC entry 2315 (class 2604 OID 1955135)
-- Dependencies: 1709 1708 1709
-- Name: placement_zone_assoc_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_placement_zone_assoc ALTER COLUMN placement_zone_assoc_id SET DEFAULT nextval('ox_placement_zone_assoc_placement_zone_assoc_id_seq'::regclass);


--
-- TOC entry 2319 (class 2604 OID 1955156)
-- Dependencies: 1711 1712 1712
-- Name: domain_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_plugins_channel_delivery_domains ALTER COLUMN domain_id SET DEFAULT nextval('ox_plugins_channel_delivery_domains_domain_id_seq'::regclass);


--
-- TOC entry 2321 (class 2604 OID 1955166)
-- Dependencies: 1713 1714 1714
-- Name: rule_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_plugins_channel_delivery_rules ALTER COLUMN rule_id SET DEFAULT nextval('ox_plugins_channel_delivery_rules_rule_id_seq'::regclass);


--
-- TOC entry 2325 (class 2604 OID 1955180)
-- Dependencies: 1716 1715 1716
-- Name: preference_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_preferences ALTER COLUMN preference_id SET DEFAULT nextval('ox_preferences_preference_id_seq'::regclass);


--
-- TOC entry 2334 (class 2604 OID 1955210)
-- Dependencies: 1720 1719 1720
-- Name: tracker_append_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_tracker_append ALTER COLUMN tracker_append_id SET DEFAULT nextval('ox_tracker_append_tracker_append_id_seq'::regclass);


--
-- TOC entry 2340 (class 2604 OID 1955227)
-- Dependencies: 1722 1721 1722
-- Name: trackerid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_trackers ALTER COLUMN trackerid SET DEFAULT nextval('ox_trackers_trackerid_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 1954470)
-- Dependencies: 1647 1646 1647
-- Name: upgrade_action_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_upgrade_action ALTER COLUMN upgrade_action_id SET DEFAULT nextval('ox_upgrade_action_upgrade_action_id_seq'::regclass);


--
-- TOC entry 2352 (class 2604 OID 1955250)
-- Dependencies: 1724 1723 1724
-- Name: userlogid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_userlog ALTER COLUMN userlogid SET DEFAULT nextval('ox_userlog_userlogid_seq'::regclass);


--
-- TOC entry 2357 (class 2604 OID 1955265)
-- Dependencies: 1726 1725 1726
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_users ALTER COLUMN user_id SET DEFAULT nextval('ox_users_user_id_seq'::regclass);


--
-- TOC entry 2364 (class 2604 OID 1955291)
-- Dependencies: 1729 1728 1729
-- Name: variableid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_variables ALTER COLUMN variableid SET DEFAULT nextval('ox_variables_variableid_seq'::regclass);


--
-- TOC entry 2374 (class 2604 OID 1955313)
-- Dependencies: 1730 1731 1731
-- Name: zoneid; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ox_zones ALTER COLUMN zoneid SET DEFAULT nextval('ox_zones_zoneid_seq'::regclass);


--
-- TOC entry 2587 (class 0 OID 1954483)
-- Dependencies: 1648
-- Data for Name: ox_account_preference_assoc; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 1, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 2, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 3, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 4, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 5, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 6, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 7, '100');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 8, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 9, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 10, '100');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 11, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 12, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 13, '100');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 14, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 16, '4');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 17, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 18, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 19, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 20, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 21, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 22, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 23, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 24, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 25, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 26, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 27, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 28, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 29, '2');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 30, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 31, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 32, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 33, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 34, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 35, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 36, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 37, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 38, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 39, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 40, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 41, '2');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 42, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 43, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 44, '3');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 45, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 46, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 47, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 48, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 49, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 50, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 51, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 52, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 53, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 54, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 55, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 56, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 57, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 58, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 59, '4');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 60, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 61, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 62, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 63, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 64, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 65, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 66, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 67, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 68, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 69, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 70, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 71, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 72, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 73, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 74, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 75, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 76, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 77, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 78, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 79, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 80, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 81, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 82, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 83, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 84, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 85, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 86, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 87, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 88, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 89, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 90, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 91, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 92, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 93, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 94, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 95, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 96, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 97, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 98, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 99, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 100, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 101, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 102, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 103, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 104, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 105, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 106, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 107, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 108, '1');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 109, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 110, '5');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 111, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 112, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 113, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 114, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 115, '');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 116, '0');
INSERT INTO ox_account_preference_assoc (account_id, preference_id, value) VALUES (1, 15, 'Europe/Warsaw');


--
-- TOC entry 2588 (class 0 OID 1954492)
-- Dependencies: 1649
-- Data for Name: ox_account_user_assoc; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_account_user_assoc (account_id, user_id, linked) VALUES (1, 1, '2009-02-26 14:56:50');
INSERT INTO ox_account_user_assoc (account_id, user_id, linked) VALUES (2, 1, '2009-02-26 14:56:50');


--
-- TOC entry 2589 (class 0 OID 1954498)
-- Dependencies: 1650
-- Data for Name: ox_account_user_permission_assoc; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2590 (class 0 OID 1954506)
-- Dependencies: 1652
-- Data for Name: ox_accounts; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_accounts (account_id, account_type, account_name, m2m_password, m2m_ticket) VALUES (1, 'ADMIN', 'Administrator account', 'QTQ!P-p-rnRP2KXj8v!HNd7vP', 'w36JW7JdrN%FrtX#m@K^^eD#1SCaa9');
INSERT INTO ox_accounts (account_id, account_type, account_name, m2m_password, m2m_ticket) VALUES (3, 'ADVERTISER', 'Advertiser 1', NULL, NULL);
INSERT INTO ox_accounts (account_id, account_type, account_name, m2m_password, m2m_ticket) VALUES (2, 'MANAGER', 'Default manager', 'h0_gKaSlHN@Zp^0#b38KJEbw#', 'w38CdJrp(Pej7u5pSByf$smnQ4nwY9');


--
-- TOC entry 2591 (class 0 OID 1954517)
-- Dependencies: 1653
-- Data for Name: ox_acls; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2592 (class 0 OID 1954532)
-- Dependencies: 1654
-- Data for Name: ox_acls_channel; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2593 (class 0 OID 1954549)
-- Dependencies: 1656
-- Data for Name: ox_ad_category_assoc; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2594 (class 0 OID 1954557)
-- Dependencies: 1658
-- Data for Name: ox_ad_zone_assoc; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (1, 0, 1, 1, 0, 1670960, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (2, 1, 1, 0.90000000000000002, 1, 100, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (3, 0, 2, 0, 0, 1, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (4, 1, 2, 0, 1, 1, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (6, 0, 3, 0, 0, 0, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (7, 2, 3, 0, 1, 0, 1);
INSERT INTO ox_ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type, priority_factor, to_be_delivered) VALUES (8, 2, 1, 0, 1, 0, 1);


--
-- TOC entry 2595 (class 0 OID 1954571)
-- Dependencies: 1660
-- Data for Name: ox_affiliates; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_affiliates (affiliateid, agencyid, name, mnemonic, comments, contact, email, website, updated, an_website_id, oac_country_code, oac_language_id, oac_category_id, as_website_id, account_id) VALUES (1, 1, 'Agency Publisher 1', '', '', 'Andrew Hill', 'andrew.hill@openads.org', 'http://fornax.net', '2007-05-15 13:41:40', NULL, '  ', NULL, NULL, NULL, 1);


--
-- TOC entry 2596 (class 0 OID 1954590)
-- Dependencies: 1661
-- Data for Name: ox_affiliates_extra; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2597 (class 0 OID 1954612)
-- Dependencies: 1663
-- Data for Name: ox_agency; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_agency (agencyid, name, contact, email, logout_url, active, updated, account_id) VALUES (1, 'Default manager', NULL, '', NULL, 1, '2009-02-26 13:56:50', 2);


--
-- TOC entry 2598 (class 0 OID 1954628)
-- Dependencies: 1664
-- Data for Name: ox_application_variable; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_application_variable (name, value) VALUES ('tables_core', '583');
INSERT INTO ox_application_variable (name, value) VALUES ('oa_version', '2.6.4');
INSERT INTO ox_application_variable (name, value) VALUES ('platform_hash', '67c6e557c8ee27648511c7a560d43699d385d864');
INSERT INTO ox_application_variable (name, value) VALUES ('sync_last_run', '2009-02-26 14:56:49');
INSERT INTO ox_application_variable (name, value) VALUES ('sync_cache', 'b:0;');
INSERT INTO ox_application_variable (name, value) VALUES ('sync_timestamp', '1235656609');
INSERT INTO ox_application_variable (name, value) VALUES ('admin_account_id', '1');


--
-- TOC entry 2599 (class 0 OID 1954640)
-- Dependencies: 1666
-- Data for Name: ox_audit; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (1, 1, 'accounts', 1, NULL, 'a:4:{s:10:"account_id";i:1;s:12:"account_type";s:5:"ADMIN";s:12:"account_name";s:21:"Administrator account";s:8:"key_desc";s:21:"Administrator account";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (2, 1, 'accounts', 2, NULL, 'a:4:{s:10:"account_id";i:2;s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:8:"key_desc";s:15:"Default manager";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 2, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (3, 1, 'agency', 1, NULL, 'a:9:{s:8:"agencyid";i:1;s:4:"name";s:15:"Default manager";s:7:"contact";s:4:"null";s:5:"email";s:4:"null";s:10:"logout_url";s:4:"null";s:6:"active";i:1;s:7:"updated";s:19:"2009-02-26 13:56:50";s:10:"account_id";i:2;s:8:"key_desc";s:15:"Default manager";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 2, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (4, 1, 'users', 1, NULL, 'a:14:{s:7:"user_id";i:1;s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"password";s:6:"******";s:8:"language";s:2:"en";s:18:"default_account_id";i:2;s:8:"comments";s:0:"";s:6:"active";s:4:"null";s:11:"sso_user_id";i:0;s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:4:"null";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"key_desc";s:5:"openx";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (5, 1, 'account_user_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:7:"user_id";i:1;s:6:"linked";s:19:"2009-02-26 14:56:50";s:8:"key_desc";s:21:"Account #1 -> User #1";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (6, 1, 'account_user_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:2;s:7:"user_id";i:1;s:6:"linked";s:19:"2009-02-26 14:56:50";s:8:"key_desc";s:21:"Account #2 -> User #1";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 2, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (7, 1, 'preferences', 1, NULL, 'a:4:{s:13:"preference_id";i:1;s:15:"preference_name";s:24:"default_banner_image_url";s:12:"account_type";s:10:"TRAFFICKER";s:8:"key_desc";s:24:"default_banner_image_url";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (8, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:1;s:5:"value";s:0:"";s:8:"key_desc";s:27:"Account #1 -> Preference #1";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (9, 1, 'preferences', 2, NULL, 'a:4:{s:13:"preference_id";i:2;s:15:"preference_name";s:30:"default_banner_destination_url";s:12:"account_type";s:10:"TRAFFICKER";s:8:"key_desc";s:30:"default_banner_destination_url";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (10, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:2;s:5:"value";s:0:"";s:8:"key_desc";s:27:"Account #1 -> Preference #2";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (11, 1, 'preferences', 3, NULL, 'a:4:{s:13:"preference_id";i:3;s:15:"preference_name";s:42:"auto_alter_html_banners_for_click_tracking";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:42:"auto_alter_html_banners_for_click_tracking";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (12, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:3;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #3";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (13, 1, 'preferences', 4, NULL, 'a:4:{s:13:"preference_id";i:4;s:15:"preference_name";s:21:"default_banner_weight";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:21:"default_banner_weight";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (14, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:4;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #4";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (15, 1, 'preferences', 5, NULL, 'a:4:{s:13:"preference_id";i:5;s:15:"preference_name";s:23:"default_campaign_weight";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:23:"default_campaign_weight";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (16, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:5;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #5";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (17, 1, 'preferences', 6, NULL, 'a:4:{s:13:"preference_id";i:6;s:15:"preference_name";s:16:"warn_email_admin";s:12:"account_type";s:5:"ADMIN";s:8:"key_desc";s:16:"warn_email_admin";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (18, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:6;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #6";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (19, 1, 'preferences', 7, NULL, 'a:4:{s:13:"preference_id";i:7;s:15:"preference_name";s:33:"warn_email_admin_impression_limit";s:12:"account_type";s:5:"ADMIN";s:8:"key_desc";s:33:"warn_email_admin_impression_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (20, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:7;s:5:"value";s:3:"100";s:8:"key_desc";s:27:"Account #1 -> Preference #7";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (21, 1, 'preferences', 8, NULL, 'a:4:{s:13:"preference_id";i:8;s:15:"preference_name";s:26:"warn_email_admin_day_limit";s:12:"account_type";s:5:"ADMIN";s:8:"key_desc";s:26:"warn_email_admin_day_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (22, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:8;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #8";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (23, 1, 'preferences', 9, NULL, 'a:4:{s:13:"preference_id";i:9;s:15:"preference_name";s:18:"warn_email_manager";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"warn_email_manager";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (24, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:9;s:5:"value";s:1:"1";s:8:"key_desc";s:27:"Account #1 -> Preference #9";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (25, 1, 'preferences', 10, NULL, 'a:4:{s:13:"preference_id";i:10;s:15:"preference_name";s:35:"warn_email_manager_impression_limit";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:35:"warn_email_manager_impression_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (26, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:10;s:5:"value";s:3:"100";s:8:"key_desc";s:28:"Account #1 -> Preference #10";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (27, 1, 'preferences', 11, NULL, 'a:4:{s:13:"preference_id";i:11;s:15:"preference_name";s:28:"warn_email_manager_day_limit";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:28:"warn_email_manager_day_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (28, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:11;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #11";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (29, 1, 'preferences', 12, NULL, 'a:4:{s:13:"preference_id";i:12;s:15:"preference_name";s:21:"warn_email_advertiser";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:21:"warn_email_advertiser";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (30, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:12;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #12";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (31, 1, 'preferences', 13, NULL, 'a:4:{s:13:"preference_id";i:13;s:15:"preference_name";s:38:"warn_email_advertiser_impression_limit";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:38:"warn_email_advertiser_impression_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (32, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:13;s:5:"value";s:3:"100";s:8:"key_desc";s:28:"Account #1 -> Preference #13";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (33, 1, 'preferences', 14, NULL, 'a:4:{s:13:"preference_id";i:14;s:15:"preference_name";s:31:"warn_email_advertiser_day_limit";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:31:"warn_email_advertiser_day_limit";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (34, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:14;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #14";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (35, 1, 'preferences', 15, NULL, 'a:4:{s:13:"preference_id";i:15;s:15:"preference_name";s:8:"timezone";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:8:"timezone";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (36, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:15;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #15";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (37, 1, 'preferences', 16, NULL, 'a:4:{s:13:"preference_id";i:16;s:15:"preference_name";s:22:"tracker_default_status";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:22:"tracker_default_status";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (38, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:16;s:5:"value";s:1:"4";s:8:"key_desc";s:28:"Account #1 -> Preference #16";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (39, 1, 'preferences', 17, NULL, 'a:4:{s:13:"preference_id";i:17;s:15:"preference_name";s:20:"tracker_default_type";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:20:"tracker_default_type";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (40, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:17;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #17";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (41, 1, 'preferences', 18, NULL, 'a:4:{s:13:"preference_id";i:18;s:15:"preference_name";s:22:"tracker_link_campaigns";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:22:"tracker_link_campaigns";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (42, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:18;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #18";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (43, 1, 'preferences', 19, NULL, 'a:4:{s:13:"preference_id";i:19;s:15:"preference_name";s:21:"ui_show_campaign_info";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:21:"ui_show_campaign_info";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (44, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:19;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #19";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (45, 1, 'preferences', 20, NULL, 'a:4:{s:13:"preference_id";i:20;s:15:"preference_name";s:19:"ui_show_banner_info";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:19:"ui_show_banner_info";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (46, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:20;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #20";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (47, 1, 'preferences', 21, NULL, 'a:4:{s:13:"preference_id";i:21;s:15:"preference_name";s:24:"ui_show_campaign_preview";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:24:"ui_show_campaign_preview";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (48, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:21;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #21";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (49, 1, 'preferences', 22, NULL, 'a:4:{s:13:"preference_id";i:22;s:15:"preference_name";s:19:"ui_show_banner_html";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:19:"ui_show_banner_html";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (50, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:22;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #22";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (51, 1, 'preferences', 23, NULL, 'a:4:{s:13:"preference_id";i:23;s:15:"preference_name";s:22:"ui_show_banner_preview";s:12:"account_type";s:10:"ADVERTISER";s:8:"key_desc";s:22:"ui_show_banner_preview";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (52, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:23;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #23";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (53, 1, 'preferences', 24, NULL, 'a:4:{s:13:"preference_id";i:24;s:15:"preference_name";s:16:"ui_hide_inactive";s:12:"account_type";s:0:"";s:8:"key_desc";s:16:"ui_hide_inactive";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (54, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:24;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #24";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (55, 1, 'preferences', 25, NULL, 'a:4:{s:13:"preference_id";i:25;s:15:"preference_name";s:24:"ui_show_matching_banners";s:12:"account_type";s:10:"TRAFFICKER";s:8:"key_desc";s:24:"ui_show_matching_banners";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (56, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:25;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #25";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (57, 1, 'preferences', 26, NULL, 'a:4:{s:13:"preference_id";i:26;s:15:"preference_name";s:32:"ui_show_matching_banners_parents";s:12:"account_type";s:10:"TRAFFICKER";s:8:"key_desc";s:32:"ui_show_matching_banners_parents";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (58, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:26;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #26";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (59, 1, 'preferences', 27, NULL, 'a:4:{s:13:"preference_id";i:27;s:15:"preference_name";s:14:"ui_novice_user";s:12:"account_type";s:0:"";s:8:"key_desc";s:14:"ui_novice_user";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (60, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:27;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #27";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (61, 1, 'preferences', 28, NULL, 'a:4:{s:13:"preference_id";i:28;s:15:"preference_name";s:17:"ui_week_start_day";s:12:"account_type";s:0:"";s:8:"key_desc";s:17:"ui_week_start_day";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (62, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:28;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #28";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (63, 1, 'preferences', 29, NULL, 'a:4:{s:13:"preference_id";i:29;s:15:"preference_name";s:22:"ui_percentage_decimals";s:12:"account_type";s:0:"";s:8:"key_desc";s:22:"ui_percentage_decimals";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (64, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:29;s:5:"value";s:1:"2";s:8:"key_desc";s:28:"Account #1 -> Preference #29";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (65, 1, 'preferences', 30, NULL, 'a:4:{s:13:"preference_id";i:30;s:15:"preference_name";s:12:"ui_column_id";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:12:"ui_column_id";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (66, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:30;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #30";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (67, 1, 'preferences', 31, NULL, 'a:4:{s:13:"preference_id";i:31;s:15:"preference_name";s:18:"ui_column_id_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"ui_column_id_label";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (68, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:31;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #31";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (69, 1, 'preferences', 32, NULL, 'a:4:{s:13:"preference_id";i:32;s:15:"preference_name";s:17:"ui_column_id_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:17:"ui_column_id_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (70, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:32;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #32";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (71, 1, 'preferences', 33, NULL, 'a:4:{s:13:"preference_id";i:33;s:15:"preference_name";s:18:"ui_column_requests";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"ui_column_requests";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (72, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:33;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #33";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (73, 1, 'preferences', 34, NULL, 'a:4:{s:13:"preference_id";i:34;s:15:"preference_name";s:24:"ui_column_requests_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:24:"ui_column_requests_label";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (74, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:34;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #34";}', 0, 'Installer', 0, '2009-02-26 13:56:50', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (75, 1, 'preferences', 35, NULL, 'a:4:{s:13:"preference_id";i:35;s:15:"preference_name";s:23:"ui_column_requests_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:23:"ui_column_requests_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (76, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:35;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #35";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (77, 1, 'preferences', 36, NULL, 'a:4:{s:13:"preference_id";i:36;s:15:"preference_name";s:21:"ui_column_impressions";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_impressions";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (78, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:36;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #36";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (79, 1, 'preferences', 37, NULL, 'a:4:{s:13:"preference_id";i:37;s:15:"preference_name";s:27:"ui_column_impressions_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:27:"ui_column_impressions_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (80, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:37;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #37";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (81, 1, 'preferences', 38, NULL, 'a:4:{s:13:"preference_id";i:38;s:15:"preference_name";s:26:"ui_column_impressions_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:26:"ui_column_impressions_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (82, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:38;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #38";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (83, 1, 'preferences', 39, NULL, 'a:4:{s:13:"preference_id";i:39;s:15:"preference_name";s:16:"ui_column_clicks";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:16:"ui_column_clicks";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (84, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:39;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #39";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (85, 1, 'preferences', 40, NULL, 'a:4:{s:13:"preference_id";i:40;s:15:"preference_name";s:22:"ui_column_clicks_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_clicks_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (86, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:40;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #40";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (87, 1, 'preferences', 41, NULL, 'a:4:{s:13:"preference_id";i:41;s:15:"preference_name";s:21:"ui_column_clicks_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_clicks_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (88, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:41;s:5:"value";s:1:"2";s:8:"key_desc";s:28:"Account #1 -> Preference #41";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (89, 1, 'preferences', 42, NULL, 'a:4:{s:13:"preference_id";i:42;s:15:"preference_name";s:13:"ui_column_ctr";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:13:"ui_column_ctr";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (90, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:42;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #42";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (91, 1, 'preferences', 43, NULL, 'a:4:{s:13:"preference_id";i:43;s:15:"preference_name";s:19:"ui_column_ctr_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_ctr_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (92, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:43;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #43";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (93, 1, 'preferences', 44, NULL, 'a:4:{s:13:"preference_id";i:44;s:15:"preference_name";s:18:"ui_column_ctr_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"ui_column_ctr_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (94, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:44;s:5:"value";s:1:"3";s:8:"key_desc";s:28:"Account #1 -> Preference #44";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (95, 1, 'preferences', 45, NULL, 'a:4:{s:13:"preference_id";i:45;s:15:"preference_name";s:21:"ui_column_conversions";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_conversions";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (96, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:45;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #45";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (97, 1, 'preferences', 46, NULL, 'a:4:{s:13:"preference_id";i:46;s:15:"preference_name";s:27:"ui_column_conversions_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:27:"ui_column_conversions_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (98, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:46;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #46";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (99, 1, 'preferences', 47, NULL, 'a:4:{s:13:"preference_id";i:47;s:15:"preference_name";s:26:"ui_column_conversions_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:26:"ui_column_conversions_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (100, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:47;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #47";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (101, 1, 'preferences', 48, NULL, 'a:4:{s:13:"preference_id";i:48;s:15:"preference_name";s:29:"ui_column_conversions_pending";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:29:"ui_column_conversions_pending";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (102, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:48;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #48";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (103, 1, 'preferences', 49, NULL, 'a:4:{s:13:"preference_id";i:49;s:15:"preference_name";s:35:"ui_column_conversions_pending_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:35:"ui_column_conversions_pending_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (104, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:49;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #49";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (105, 1, 'preferences', 50, NULL, 'a:4:{s:13:"preference_id";i:50;s:15:"preference_name";s:34:"ui_column_conversions_pending_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:34:"ui_column_conversions_pending_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (106, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:50;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #50";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (107, 1, 'preferences', 51, NULL, 'a:4:{s:13:"preference_id";i:51;s:15:"preference_name";s:18:"ui_column_sr_views";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"ui_column_sr_views";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (108, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:51;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #51";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (109, 1, 'preferences', 52, NULL, 'a:4:{s:13:"preference_id";i:52;s:15:"preference_name";s:24:"ui_column_sr_views_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:24:"ui_column_sr_views_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (110, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:52;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #52";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (111, 1, 'preferences', 53, NULL, 'a:4:{s:13:"preference_id";i:53;s:15:"preference_name";s:23:"ui_column_sr_views_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:23:"ui_column_sr_views_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (112, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:53;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #53";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (113, 1, 'preferences', 54, NULL, 'a:4:{s:13:"preference_id";i:54;s:15:"preference_name";s:19:"ui_column_sr_clicks";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_sr_clicks";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (114, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:54;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #54";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (115, 1, 'preferences', 55, NULL, 'a:4:{s:13:"preference_id";i:55;s:15:"preference_name";s:25:"ui_column_sr_clicks_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:25:"ui_column_sr_clicks_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (116, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:55;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #55";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (117, 1, 'preferences', 56, NULL, 'a:4:{s:13:"preference_id";i:56;s:15:"preference_name";s:24:"ui_column_sr_clicks_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:24:"ui_column_sr_clicks_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (118, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:56;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #56";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (119, 1, 'preferences', 57, NULL, 'a:4:{s:13:"preference_id";i:57;s:15:"preference_name";s:17:"ui_column_revenue";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:17:"ui_column_revenue";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (120, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:57;s:5:"value";s:1:"1";s:8:"key_desc";s:28:"Account #1 -> Preference #57";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (121, 1, 'preferences', 58, NULL, 'a:4:{s:13:"preference_id";i:58;s:15:"preference_name";s:23:"ui_column_revenue_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:23:"ui_column_revenue_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (122, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:58;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #58";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (123, 1, 'preferences', 59, NULL, 'a:4:{s:13:"preference_id";i:59;s:15:"preference_name";s:22:"ui_column_revenue_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_revenue_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (124, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:59;s:5:"value";s:1:"4";s:8:"key_desc";s:28:"Account #1 -> Preference #59";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (125, 1, 'preferences', 60, NULL, 'a:4:{s:13:"preference_id";i:60;s:15:"preference_name";s:14:"ui_column_cost";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_cost";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (126, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:60;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #60";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (127, 1, 'preferences', 61, NULL, 'a:4:{s:13:"preference_id";i:61;s:15:"preference_name";s:20:"ui_column_cost_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_cost_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (128, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:61;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #61";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (129, 1, 'preferences', 62, NULL, 'a:4:{s:13:"preference_id";i:62;s:15:"preference_name";s:19:"ui_column_cost_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_cost_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (130, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:62;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #62";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (131, 1, 'preferences', 63, NULL, 'a:4:{s:13:"preference_id";i:63;s:15:"preference_name";s:12:"ui_column_bv";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:12:"ui_column_bv";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (132, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:63;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #63";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (133, 1, 'preferences', 64, NULL, 'a:4:{s:13:"preference_id";i:64;s:15:"preference_name";s:18:"ui_column_bv_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:18:"ui_column_bv_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (134, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:64;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #64";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (135, 1, 'preferences', 65, NULL, 'a:4:{s:13:"preference_id";i:65;s:15:"preference_name";s:17:"ui_column_bv_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:17:"ui_column_bv_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (136, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:65;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #65";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (137, 1, 'preferences', 66, NULL, 'a:4:{s:13:"preference_id";i:66;s:15:"preference_name";s:19:"ui_column_num_items";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_num_items";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (138, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:66;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #66";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (139, 1, 'preferences', 67, NULL, 'a:4:{s:13:"preference_id";i:67;s:15:"preference_name";s:25:"ui_column_num_items_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:25:"ui_column_num_items_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (140, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:67;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #67";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (141, 1, 'preferences', 68, NULL, 'a:4:{s:13:"preference_id";i:68;s:15:"preference_name";s:24:"ui_column_num_items_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:24:"ui_column_num_items_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (142, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:68;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #68";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (143, 1, 'preferences', 69, NULL, 'a:4:{s:13:"preference_id";i:69;s:15:"preference_name";s:16:"ui_column_revcpc";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:16:"ui_column_revcpc";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (144, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:69;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #69";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (145, 1, 'preferences', 70, NULL, 'a:4:{s:13:"preference_id";i:70;s:15:"preference_name";s:22:"ui_column_revcpc_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_revcpc_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (146, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:70;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #70";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (147, 1, 'preferences', 71, NULL, 'a:4:{s:13:"preference_id";i:71;s:15:"preference_name";s:21:"ui_column_revcpc_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_revcpc_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (148, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:71;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #71";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (149, 1, 'preferences', 72, NULL, 'a:4:{s:13:"preference_id";i:72;s:15:"preference_name";s:17:"ui_column_costcpc";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:17:"ui_column_costcpc";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (150, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:72;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #72";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (151, 1, 'preferences', 73, NULL, 'a:4:{s:13:"preference_id";i:73;s:15:"preference_name";s:23:"ui_column_costcpc_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:23:"ui_column_costcpc_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (152, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:73;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #73";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (153, 1, 'preferences', 74, NULL, 'a:4:{s:13:"preference_id";i:74;s:15:"preference_name";s:22:"ui_column_costcpc_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_costcpc_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (154, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:74;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #74";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (155, 1, 'preferences', 75, NULL, 'a:4:{s:13:"preference_id";i:75;s:15:"preference_name";s:25:"ui_column_technology_cost";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:25:"ui_column_technology_cost";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (156, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:75;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #75";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (157, 1, 'preferences', 76, NULL, 'a:4:{s:13:"preference_id";i:76;s:15:"preference_name";s:31:"ui_column_technology_cost_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:31:"ui_column_technology_cost_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (158, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:76;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #76";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (159, 1, 'preferences', 77, NULL, 'a:4:{s:13:"preference_id";i:77;s:15:"preference_name";s:30:"ui_column_technology_cost_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:30:"ui_column_technology_cost_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (160, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:77;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #77";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (161, 1, 'preferences', 78, NULL, 'a:4:{s:13:"preference_id";i:78;s:15:"preference_name";s:16:"ui_column_income";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:16:"ui_column_income";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (162, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:78;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #78";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (163, 1, 'preferences', 79, NULL, 'a:4:{s:13:"preference_id";i:79;s:15:"preference_name";s:22:"ui_column_income_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_income_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (164, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:79;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #79";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (165, 1, 'preferences', 80, NULL, 'a:4:{s:13:"preference_id";i:80;s:15:"preference_name";s:21:"ui_column_income_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_income_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (166, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:80;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #80";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (167, 1, 'preferences', 81, NULL, 'a:4:{s:13:"preference_id";i:81;s:15:"preference_name";s:23:"ui_column_income_margin";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:23:"ui_column_income_margin";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (168, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:81;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #81";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (169, 1, 'preferences', 82, NULL, 'a:4:{s:13:"preference_id";i:82;s:15:"preference_name";s:29:"ui_column_income_margin_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:29:"ui_column_income_margin_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (170, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:82;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #82";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (171, 1, 'preferences', 83, NULL, 'a:4:{s:13:"preference_id";i:83;s:15:"preference_name";s:28:"ui_column_income_margin_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:28:"ui_column_income_margin_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (172, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:83;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #83";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (173, 1, 'preferences', 84, NULL, 'a:4:{s:13:"preference_id";i:84;s:15:"preference_name";s:16:"ui_column_profit";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:16:"ui_column_profit";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (174, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:84;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #84";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (175, 1, 'preferences', 85, NULL, 'a:4:{s:13:"preference_id";i:85;s:15:"preference_name";s:22:"ui_column_profit_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_profit_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (176, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:85;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #85";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (177, 1, 'preferences', 86, NULL, 'a:4:{s:13:"preference_id";i:86;s:15:"preference_name";s:21:"ui_column_profit_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_profit_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (178, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:86;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #86";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (179, 1, 'preferences', 87, NULL, 'a:4:{s:13:"preference_id";i:87;s:15:"preference_name";s:16:"ui_column_margin";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:16:"ui_column_margin";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (180, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:87;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #87";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (181, 1, 'preferences', 88, NULL, 'a:4:{s:13:"preference_id";i:88;s:15:"preference_name";s:22:"ui_column_margin_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:22:"ui_column_margin_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (182, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:88;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #88";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (183, 1, 'preferences', 89, NULL, 'a:4:{s:13:"preference_id";i:89;s:15:"preference_name";s:21:"ui_column_margin_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:21:"ui_column_margin_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (184, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:89;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #89";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (185, 1, 'preferences', 90, NULL, 'a:4:{s:13:"preference_id";i:90;s:15:"preference_name";s:14:"ui_column_erpm";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_erpm";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (186, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:90;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #90";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (187, 1, 'preferences', 91, NULL, 'a:4:{s:13:"preference_id";i:91;s:15:"preference_name";s:20:"ui_column_erpm_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_erpm_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (188, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:91;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #91";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (189, 1, 'preferences', 92, NULL, 'a:4:{s:13:"preference_id";i:92;s:15:"preference_name";s:19:"ui_column_erpm_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_erpm_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (190, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:92;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #92";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (191, 1, 'preferences', 93, NULL, 'a:4:{s:13:"preference_id";i:93;s:15:"preference_name";s:14:"ui_column_erpc";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_erpc";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (192, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:93;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #93";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (193, 1, 'preferences', 94, NULL, 'a:4:{s:13:"preference_id";i:94;s:15:"preference_name";s:20:"ui_column_erpc_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_erpc_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (194, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:94;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #94";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (195, 1, 'preferences', 95, NULL, 'a:4:{s:13:"preference_id";i:95;s:15:"preference_name";s:19:"ui_column_erpc_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_erpc_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (196, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:95;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #95";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (197, 1, 'preferences', 96, NULL, 'a:4:{s:13:"preference_id";i:96;s:15:"preference_name";s:14:"ui_column_erps";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_erps";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (198, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:96;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #96";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (199, 1, 'preferences', 97, NULL, 'a:4:{s:13:"preference_id";i:97;s:15:"preference_name";s:20:"ui_column_erps_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_erps_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (200, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:97;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #97";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (201, 1, 'preferences', 98, NULL, 'a:4:{s:13:"preference_id";i:98;s:15:"preference_name";s:19:"ui_column_erps_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_erps_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (202, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:98;s:5:"value";s:1:"0";s:8:"key_desc";s:28:"Account #1 -> Preference #98";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (203, 1, 'preferences', 99, NULL, 'a:4:{s:13:"preference_id";i:99;s:15:"preference_name";s:14:"ui_column_eipm";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_eipm";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (204, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:99;s:5:"value";s:0:"";s:8:"key_desc";s:28:"Account #1 -> Preference #99";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (205, 1, 'preferences', 100, NULL, 'a:4:{s:13:"preference_id";i:100;s:15:"preference_name";s:20:"ui_column_eipm_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_eipm_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (206, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:100;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #100";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (207, 1, 'preferences', 101, NULL, 'a:4:{s:13:"preference_id";i:101;s:15:"preference_name";s:19:"ui_column_eipm_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_eipm_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (208, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:101;s:5:"value";s:1:"0";s:8:"key_desc";s:29:"Account #1 -> Preference #101";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (209, 1, 'preferences', 102, NULL, 'a:4:{s:13:"preference_id";i:102;s:15:"preference_name";s:14:"ui_column_eipc";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_eipc";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (210, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:102;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #102";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (211, 1, 'preferences', 103, NULL, 'a:4:{s:13:"preference_id";i:103;s:15:"preference_name";s:20:"ui_column_eipc_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_eipc_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (212, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:103;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #103";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (213, 1, 'preferences', 104, NULL, 'a:4:{s:13:"preference_id";i:104;s:15:"preference_name";s:19:"ui_column_eipc_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_eipc_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (214, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:104;s:5:"value";s:1:"0";s:8:"key_desc";s:29:"Account #1 -> Preference #104";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (215, 1, 'preferences', 105, NULL, 'a:4:{s:13:"preference_id";i:105;s:15:"preference_name";s:14:"ui_column_eips";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_eips";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (216, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:105;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #105";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (217, 1, 'preferences', 106, NULL, 'a:4:{s:13:"preference_id";i:106;s:15:"preference_name";s:20:"ui_column_eips_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_eips_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (218, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:106;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #106";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (219, 1, 'preferences', 107, NULL, 'a:4:{s:13:"preference_id";i:107;s:15:"preference_name";s:19:"ui_column_eips_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_eips_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (220, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:107;s:5:"value";s:1:"0";s:8:"key_desc";s:29:"Account #1 -> Preference #107";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (221, 1, 'preferences', 108, NULL, 'a:4:{s:13:"preference_id";i:108;s:15:"preference_name";s:14:"ui_column_ecpm";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_ecpm";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (222, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:108;s:5:"value";s:1:"1";s:8:"key_desc";s:29:"Account #1 -> Preference #108";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (223, 1, 'preferences', 109, NULL, 'a:4:{s:13:"preference_id";i:109;s:15:"preference_name";s:20:"ui_column_ecpm_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_ecpm_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (224, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:109;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #109";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (225, 1, 'preferences', 110, NULL, 'a:4:{s:13:"preference_id";i:110;s:15:"preference_name";s:19:"ui_column_ecpm_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_ecpm_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (226, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:110;s:5:"value";s:1:"5";s:8:"key_desc";s:29:"Account #1 -> Preference #110";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (227, 1, 'preferences', 111, NULL, 'a:4:{s:13:"preference_id";i:111;s:15:"preference_name";s:14:"ui_column_ecpc";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_ecpc";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (228, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:111;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #111";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (229, 1, 'preferences', 112, NULL, 'a:4:{s:13:"preference_id";i:112;s:15:"preference_name";s:20:"ui_column_ecpc_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_ecpc_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (230, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:112;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #112";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (231, 1, 'preferences', 113, NULL, 'a:4:{s:13:"preference_id";i:113;s:15:"preference_name";s:19:"ui_column_ecpc_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_ecpc_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (232, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:113;s:5:"value";s:1:"0";s:8:"key_desc";s:29:"Account #1 -> Preference #113";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (233, 1, 'preferences', 114, NULL, 'a:4:{s:13:"preference_id";i:114;s:15:"preference_name";s:14:"ui_column_ecps";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:14:"ui_column_ecps";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (234, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:114;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #114";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (235, 1, 'preferences', 115, NULL, 'a:4:{s:13:"preference_id";i:115;s:15:"preference_name";s:20:"ui_column_ecps_label";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:20:"ui_column_ecps_label";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (236, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:115;s:5:"value";s:0:"";s:8:"key_desc";s:29:"Account #1 -> Preference #115";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (237, 1, 'preferences', 116, NULL, 'a:4:{s:13:"preference_id";i:116;s:15:"preference_name";s:19:"ui_column_ecps_rank";s:12:"account_type";s:7:"MANAGER";s:8:"key_desc";s:19:"ui_column_ecps_rank";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (238, 1, 'account_preference_assoc', 0, NULL, 'a:4:{s:10:"account_id";i:1;s:13:"preference_id";i:116;s:5:"value";s:1:"0";s:8:"key_desc";s:29:"Account #1 -> Preference #116";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (239, 2, 'account_preference_assoc', 0, NULL, 'a:2:{s:5:"value";a:2:{s:3:"was";s:0:"";s:2:"is";s:13:"Europe/Warsaw";}s:8:"key_desc";s:28:"Account #1 -> Preference #15";}', 0, 'Installer', 0, '2009-02-26 13:56:51', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (240, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";N;s:2:"is";s:19:"2009-02-26 13:56:53";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 13:56:54', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (241, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";s:19:"2009-02-26 13:56:53";s:2:"is";s:19:"2009-02-26 13:57:25";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 13:57:25', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (242, 1, 'accounts', 3, NULL, 'a:4:{s:10:"account_id";i:3;s:12:"account_type";s:10:"ADVERTISER";s:12:"account_name";s:12:"Advertiser 1";s:8:"key_desc";s:12:"Advertiser 1";}', 1, 'openx', 0, '2009-02-26 13:57:34', 1, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (243, 1, 'clients', 1, NULL, 'a:17:{s:8:"clientid";i:1;s:8:"agencyid";i:1;s:10:"clientname";s:12:"Advertiser 1";s:7:"contact";s:10:"advertiser";s:5:"email";s:19:"example@example.com";s:6:"report";s:1:"f";s:14:"reportinterval";i:7;s:14:"reportlastdate";s:10:"2009-02-26";s:16:"reportdeactivate";s:1:"t";s:8:"comments";s:0:"";s:7:"updated";s:19:"2009-02-26 13:57:34";s:12:"lb_reporting";s:4:"null";s:15:"an_adnetwork_id";i:0;s:16:"as_advertiser_id";i:0;s:10:"account_id";i:3;s:21:"advertiser_limitation";s:5:"false";s:8:"key_desc";s:12:"Advertiser 1";}', 1, 'openx', 0, '2009-02-26 13:57:34', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (244, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";s:19:"2009-02-26 13:57:25";s:2:"is";s:19:"2009-02-26 13:57:35";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 13:57:35', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (245, 1, 'campaigns', 1, NULL, 'a:30:{s:10:"campaignid";i:1;s:12:"campaignname";s:31:"Advertiser 1 - Default Campaign";s:8:"clientid";i:1;s:5:"views";i:-1;s:6:"clicks";i:-1;s:11:"conversions";i:-1;s:6:"expire";s:10:"2007-07-01";s:8:"activate";i:0;s:8:"priority";i:0;s:6:"weight";i:1;s:17:"target_impression";i:0;s:12:"target_click";i:0;s:17:"target_conversion";i:0;s:9:"anonymous";s:1:"f";s:9:"companion";i:0;s:8:"comments";s:0:"";s:7:"revenue";i:0;s:12:"revenue_type";i:0;s:7:"updated";s:19:"2009-02-26 13:57:43";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:14:"an_campaign_id";i:0;s:14:"as_campaign_id";i:0;s:6:"status";i:3;s:9:"an_status";i:0;s:16:"as_reject_reason";i:0;s:12:"hosted_views";i:0;s:13:"hosted_clicks";i:0;s:8:"key_desc";s:31:"Advertiser 1 - Default Campaign";}', 1, 'openx', 0, '2009-02-26 13:57:43', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (246, 1, 'campaigns', 2, NULL, 'a:30:{s:10:"campaignid";i:2;s:12:"campaignname";s:13:"test campaign";s:8:"clientid";i:1;s:5:"views";i:-1;s:6:"clicks";i:-1;s:11:"conversions";i:-1;s:6:"expire";i:0;s:8:"activate";i:0;s:8:"priority";i:0;s:6:"weight";i:1;s:17:"target_impression";i:0;s:12:"target_click";i:0;s:17:"target_conversion";i:0;s:9:"anonymous";s:1:"f";s:9:"companion";i:0;s:8:"comments";s:0:"";s:7:"revenue";i:0;s:12:"revenue_type";i:0;s:7:"updated";s:19:"2009-02-26 13:57:44";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:14:"an_campaign_id";i:0;s:14:"as_campaign_id";i:0;s:6:"status";i:0;s:9:"an_status";i:0;s:16:"as_reject_reason";i:0;s:12:"hosted_views";i:0;s:13:"hosted_clicks";i:0;s:8:"key_desc";s:13:"test campaign";}', 1, 'openx', 0, '2009-02-26 13:57:44', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (247, 1, 'campaigns', 3, NULL, 'a:30:{s:10:"campaignid";i:3;s:12:"campaignname";s:16:"campaign 2 (gif)";s:8:"clientid";i:1;s:5:"views";i:-1;s:6:"clicks";i:-1;s:11:"conversions";i:-1;s:6:"expire";i:0;s:8:"activate";i:0;s:8:"priority";i:0;s:6:"weight";i:1;s:17:"target_impression";i:0;s:12:"target_click";i:0;s:17:"target_conversion";i:0;s:9:"anonymous";s:1:"f";s:9:"companion";i:0;s:8:"comments";s:0:"";s:7:"revenue";i:0;s:12:"revenue_type";i:0;s:7:"updated";s:19:"2009-02-26 13:57:46";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:14:"an_campaign_id";i:0;s:14:"as_campaign_id";i:0;s:6:"status";i:0;s:9:"an_status";i:0;s:16:"as_reject_reason";i:0;s:12:"hosted_views";i:0;s:13:"hosted_clicks";i:0;s:8:"key_desc";s:16:"campaign 2 (gif)";}', 1, 'openx', 0, '2009-02-26 13:57:46', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (248, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";s:19:"2009-02-26 13:57:35";s:2:"is";s:19:"2009-02-26 13:57:47";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 13:57:47', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (249, 1, 'images', 0, NULL, 'a:4:{s:8:"filename";s:4:"null";s:8:"contents";s:11:"Binary data";s:7:"t_stamp";s:4:"null";s:8:"key_desc";s:10:"468x60.gif";}', 1, 'openx', 0, '2009-02-26 13:57:58', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (250, 1, 'banners', 3, NULL, 'a:44:{s:8:"bannerid";i:3;s:10:"campaignid";i:3;s:11:"contenttype";s:3:"gif";s:13:"pluginversion";i:0;s:11:"storagetype";s:3:"sql";s:8:"filename";s:10:"468x60.gif";s:8:"imageurl";s:0:"";s:12:"htmltemplate";s:0:"";s:9:"htmlcache";s:0:"";s:5:"width";i:468;s:6:"height";i:60;s:6:"weight";i:1;s:3:"seq";i:0;s:6:"target";s:0:"";s:3:"url";s:28:"https://developer.openx.org/";s:3:"alt";s:8:"alt text";s:10:"statustext";s:0:"";s:10:"bannertext";s:0:"";s:11:"description";s:17:"sample gif banner";s:8:"autohtml";s:1:"f";s:8:"adserver";s:0:"";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:18:"compiledlimitation";s:0:"";s:11:"acl_plugins";s:0:"";s:6:"append";s:0:"";s:10:"appendtype";i:0;s:10:"bannertype";i:0;s:12:"alt_filename";s:0:"";s:12:"alt_imageurl";s:4:"null";s:15:"alt_contenttype";s:0:"";s:8:"comments";s:0:"";s:7:"updated";s:19:"2009-02-26 13:57:58";s:12:"acls_updated";s:4:"null";s:7:"keyword";s:0:"";s:11:"transparent";s:4:"null";s:10:"parameters";s:2:"N;";s:12:"an_banner_id";i:0;s:12:"as_banner_id";i:0;s:6:"status";i:0;s:16:"ad_direct_status";i:0;s:29:"ad_direct_rejection_reason_id";i:0;s:8:"key_desc";s:17:"sample gif banner";}', 1, 'openx', 0, '2009-02-26 13:57:58', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (251, 1, 'ad_zone_assoc', 6, NULL, 'a:8:{s:16:"ad_zone_assoc_id";i:6;s:7:"zone_id";i:0;s:5:"ad_id";i:3;s:8:"priority";i:0;s:9:"link_type";i:0;s:15:"priority_factor";i:0;s:15:"to_be_delivered";s:4:"null";s:8:"key_desc";s:16:"Ad #3 -> Zone #0";}', 1, 'openx', 0, '2009-02-26 13:57:58', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (252, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";s:19:"2009-02-26 13:57:47";s:2:"is";s:19:"2009-02-26 13:57:59";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 13:57:59', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (253, 2, 'users', 1, NULL, 'a:2:{s:15:"date_last_login";a:2:{s:3:"was";s:19:"2009-02-26 13:57:59";s:2:"is";s:19:"2009-02-26 16:16:54";}s:8:"key_desc";N;}', 0, NULL, 0, '2009-02-26 16:16:54', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (254, 1, 'zones', 1, NULL, 'a:32:{s:6:"zoneid";i:1;s:11:"affiliateid";i:1;s:8:"zonename";s:21:"Publisher 1 - Default";s:11:"description";s:0:"";s:8:"delivery";i:0;s:8:"zonetype";i:3;s:8:"category";s:0:"";s:5:"width";i:468;s:6:"height";i:60;s:12:"ad_selection";s:0:"";s:5:"chain";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:10:"appendtype";i:0;s:11:"forceappend";s:4:"null";s:23:"inventory_forecast_type";i:0;s:8:"comments";s:0:"";s:4:"cost";i:0;s:9:"cost_type";i:0;s:16:"cost_variable_id";s:4:"null";s:15:"technology_cost";i:0;s:20:"technology_cost_type";i:0;s:7:"updated";s:19:"2009-02-26 16:17:47";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:4:"what";s:0:"";s:10:"as_zone_id";i:0;s:15:"is_in_ad_direct";s:4:"null";s:4:"rate";i:0;s:7:"pricing";s:4:"null";s:8:"key_desc";s:21:"Publisher 1 - Default";}', 1, 'openx', 0, '2009-02-26 16:17:47', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (255, 1, 'zones', 2, NULL, 'a:32:{s:6:"zoneid";i:2;s:11:"affiliateid";i:1;s:8:"zonename";s:28:"Agency Publisher 1 - Default";s:11:"description";s:0:"";s:8:"delivery";i:0;s:8:"zonetype";i:3;s:8:"category";s:0:"";s:5:"width";i:468;s:6:"height";i:60;s:12:"ad_selection";s:0:"";s:5:"chain";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:10:"appendtype";i:0;s:11:"forceappend";s:4:"null";s:23:"inventory_forecast_type";i:0;s:8:"comments";s:0:"";s:4:"cost";i:0;s:9:"cost_type";i:0;s:16:"cost_variable_id";s:4:"null";s:15:"technology_cost";i:0;s:20:"technology_cost_type";i:0;s:7:"updated";s:19:"2009-02-26 16:18:24";s:5:"block";i:0;s:7:"capping";i:0;s:15:"session_capping";i:0;s:4:"what";s:0:"";s:10:"as_zone_id";i:0;s:15:"is_in_ad_direct";s:4:"null";s:4:"rate";i:0;s:7:"pricing";s:4:"null";s:8:"key_desc";s:28:"Agency Publisher 1 - Default";}', 1, 'openx', 0, '2009-02-26 16:18:24', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (256, 3, 'ad_zone_assoc', 5, NULL, 'a:8:{s:16:"ad_zone_assoc_id";i:5;s:7:"zone_id";i:2;s:5:"ad_id";i:1;s:8:"priority";i:0;s:9:"link_type";i:1;s:15:"priority_factor";i:100;s:15:"to_be_delivered";s:4:"true";s:8:"key_desc";s:16:"Ad #1 -> Zone #2";}', 1, 'openx', 0, '2009-02-26 16:18:49', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (257, 1, 'placement_zone_assoc', 4, NULL, 'a:4:{s:23:"placement_zone_assoc_id";i:4;s:7:"zone_id";i:2;s:12:"placement_id";i:1;s:8:"key_desc";s:22:"Campaign #1 -> Zone #2";}', 1, 'openx', 0, '2009-02-26 16:18:54', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (258, 1, 'ad_zone_assoc', 8, NULL, 'a:8:{s:16:"ad_zone_assoc_id";i:8;s:7:"zone_id";i:2;s:5:"ad_id";i:1;s:8:"priority";i:0;s:9:"link_type";i:0;s:15:"priority_factor";i:0;s:15:"to_be_delivered";s:4:"null";s:8:"key_desc";s:16:"Ad #1 -> Zone #2";}', 1, 'openx', 0, '2009-02-26 16:18:54', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (259, 1, 'channel', 1, NULL, 'a:12:{s:9:"channelid";i:1;s:8:"agencyid";i:1;s:11:"affiliateid";i:1;s:4:"name";s:20:"Test Admin Channel 2";s:11:"description";s:0:"";s:18:"compiledlimitation";s:4:"true";s:11:"acl_plugins";s:4:"true";s:6:"active";i:1;s:8:"comments";s:0:"";s:7:"updated";s:4:"null";s:12:"acls_updated";s:4:"null";s:8:"key_desc";s:20:"Test Admin Channel 2";}', 1, 'openx', 0, '2009-02-26 16:19:22', 1, NULL, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (260, 1, 'trackers', 1, NULL, 'a:14:{s:9:"trackerid";i:1;s:11:"trackername";s:14:"Sample Tracker";s:11:"description";s:0:"";s:8:"clientid";i:1;s:10:"viewwindow";i:3;s:11:"clickwindow";i:3;s:11:"blockwindow";i:0;s:6:"status";s:1:"4";s:4:"type";s:4:"true";s:13:"linkcampaigns";s:1:"f";s:14:"variablemethod";s:4:"null";s:10:"appendcode";s:0:"";s:7:"updated";s:19:"2009-02-26 16:19:52";s:8:"key_desc";s:14:"Sample Tracker";}', 1, 'openx', 0, '2009-02-26 16:19:52', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (261, 2, 'trackers', 1, NULL, 'a:3:{s:14:"variablemethod";a:2:{s:3:"was";s:7:"default";s:2:"is";s:2:"js";}s:8:"key_desc";s:14:"Sample Tracker";s:8:"clientid";s:1:"1";}', 1, 'openx', 0, '2009-02-26 16:20:23', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (262, 1, 'variables', 1, NULL, 'a:13:{s:10:"variableid";i:1;s:9:"trackerid";i:1;s:4:"name";s:3:"boo";s:11:"description";s:13:"Sample number";s:8:"datatype";s:7:"numeric";s:7:"purpose";s:4:"NULL";s:15:"reject_if_empty";s:0:"";s:9:"is_unique";i:0;s:13:"unique_window";i:0;s:12:"variablecode";s:27:"var boo = \\''%%BOO_VALUE%%\\''";s:6:"hidden";s:1:"f";s:7:"updated";s:19:"2009-02-26 16:20:23";s:8:"key_desc";s:3:"boo";}', 1, 'openx', 0, '2009-02-26 16:20:23', 2, 3, NULL);
INSERT INTO ox_audit (auditid, actionid, context, contextid, parentid, details, userid, username, usertype, updated, account_id, advertiser_account_id, website_account_id) VALUES (263, 1, 'variables', 2, NULL, 'a:13:{s:10:"variableid";i:2;s:9:"trackerid";i:1;s:4:"name";s:3:"foo";s:11:"description";s:13:"Sample string";s:8:"datatype";s:6:"string";s:7:"purpose";s:4:"NULL";s:15:"reject_if_empty";s:0:"";s:9:"is_unique";i:0;s:13:"unique_window";i:0;s:12:"variablecode";s:27:"var foo = \\''%%FOO_VALUE%%\\''";s:6:"hidden";s:1:"f";s:7:"updated";s:19:"2009-02-26 16:20:23";s:8:"key_desc";s:3:"foo";}', 1, 'openx', 0, '2009-02-26 16:20:23', 2, 3, NULL);


--
-- TOC entry 2600 (class 0 OID 1954664)
-- Dependencies: 1668
-- Data for Name: ox_banners; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_banners (bannerid, campaignid, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, statustext, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated, keyword, transparent, parameters, an_banner_id, as_banner_id, status, ad_direct_status, ad_direct_rejection_reason_id) VALUES (1, 1, 'html', 0, 'html', '', '', 'Test HTML Banner!
', 'Test HTML Banner!
', 468, 60, 1, 0, '', '', '', '', '', 'Test HTML Banner!', true, '', 0, 0, 0, '(MAX_checkSite_Channel(\\''7\\'', \\''=~\\''))', 'Site:Channel', '', 0, 0, '', '', 'gif', '', '2008-04-28 11:20:31', '2008-04-28 11:20:31', '', 0, 'N;', NULL, NULL, 0, 0, 0);
INSERT INTO ox_banners (bannerid, campaignid, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, statustext, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated, keyword, transparent, parameters, an_banner_id, as_banner_id, status, ad_direct_status, ad_direct_rejection_reason_id) VALUES (2, 2, 'html', 0, 'html', '', '', 'html test banner', '<a href="{clickurl}" target="{target}">html test banner</a>', 468, 60, 1, 0, '', 'https://developer.openx.org/', '', '', '', 'test banner', true, 'max', 0, 0, 0, '', NULL, '', 0, 0, '', '', 'gif', '', '2008-04-28 11:53:30', NULL, '', 0, 'N;', NULL, NULL, 0, 0, 0);
INSERT INTO ox_banners (bannerid, campaignid, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, statustext, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated, keyword, transparent, parameters, an_banner_id, as_banner_id, status, ad_direct_status, ad_direct_rejection_reason_id) VALUES (3, 3, 'gif', 0, 'sql', '468x60.gif', '', '', '', 468, 60, 1, 0, '', 'https://developer.openx.org/', 'alt text', '', '', 'sample gif banner', false, '', 0, 0, 0, '', NULL, '', 0, 0, '', '', '', '', '2009-02-26 13:57:58', NULL, '', 0, 'N;', NULL, NULL, 0, 0, 0);


--
-- TOC entry 2601 (class 0 OID 1954711)
-- Dependencies: 1670
-- Data for Name: ox_campaigns; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated, block, capping, session_capping, an_campaign_id, as_campaign_id, status, an_status, as_reject_reason, hosted_views, hosted_clicks) VALUES (1, 'Advertiser 1 - Default Campaign', 1, -1, -1, -1, '2007-07-01', NULL, 0, 1, 0, 0, 0, false, 0, '', NULL, NULL, '2009-02-26 13:57:43', 0, 0, 0, NULL, NULL, 3, 0, 0, 0, 0);
INSERT INTO ox_campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated, block, capping, session_capping, an_campaign_id, as_campaign_id, status, an_status, as_reject_reason, hosted_views, hosted_clicks) VALUES (2, 'test campaign', 1, -1, -1, -1, NULL, NULL, 0, 1, 0, 0, 0, false, 0, '', NULL, NULL, '2009-02-26 13:57:44', 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0);
INSERT INTO ox_campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated, block, capping, session_capping, an_campaign_id, as_campaign_id, status, an_status, as_reject_reason, hosted_views, hosted_clicks) VALUES (3, 'campaign 2 (gif)', 1, -1, -1, -1, NULL, NULL, 0, 1, 0, 0, 0, false, 0, '', NULL, NULL, '2009-02-26 13:57:46', 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0);


--
-- TOC entry 2602 (class 0 OID 1954744)
-- Dependencies: 1672
-- Data for Name: ox_campaigns_trackers; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_campaigns_trackers (campaign_trackerid, campaignid, trackerid, viewwindow, clickwindow, status) VALUES (1, 3, 1, 3, 3, 4);


--
-- TOC entry 2603 (class 0 OID 1954759)
-- Dependencies: 1674
-- Data for Name: ox_category; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2604 (class 0 OID 1954768)
-- Dependencies: 1676
-- Data for Name: ox_channel; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_channel (channelid, agencyid, affiliateid, name, description, compiledlimitation, acl_plugins, active, comments, updated, acls_updated) VALUES (1, 1, 1, 'Test Admin Channel 2', '', 'true', 'true', 1, '', NULL, NULL);


--
-- TOC entry 2605 (class 0 OID 1954784)
-- Dependencies: 1678
-- Data for Name: ox_clients; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_clients (clientid, agencyid, clientname, contact, email, report, reportinterval, reportlastdate, reportdeactivate, comments, updated, lb_reporting, an_adnetwork_id, as_advertiser_id, account_id, advertiser_limitation) VALUES (1, 1, 'Advertiser 1', 'advertiser', 'example@example.com', false, 7, '2009-02-26', true, '', '2009-02-26 13:57:34', 0, NULL, NULL, 3, 0);


--
-- TOC entry 2606 (class 0 OID 1954807)
-- Dependencies: 1680
-- Data for Name: ox_data_intermediate_ad; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2607 (class 0 OID 1954825)
-- Dependencies: 1682
-- Data for Name: ox_data_intermediate_ad_connection; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2608 (class 0 OID 1954874)
-- Dependencies: 1684
-- Data for Name: ox_data_intermediate_ad_variable_value; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2609 (class 0 OID 1954884)
-- Dependencies: 1685
-- Data for Name: ox_data_raw_ad_click; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2610 (class 0 OID 1954920)
-- Dependencies: 1686
-- Data for Name: ox_data_raw_ad_impression; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2611 (class 0 OID 1954956)
-- Dependencies: 1687
-- Data for Name: ox_data_raw_ad_request; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2612 (class 0 OID 1954983)
-- Dependencies: 1689
-- Data for Name: ox_data_raw_tracker_impression; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2613 (class 0 OID 1955021)
-- Dependencies: 1690
-- Data for Name: ox_data_raw_tracker_variable_value; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2614 (class 0 OID 1955030)
-- Dependencies: 1692
-- Data for Name: ox_data_summary_ad_hourly; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2615 (class 0 OID 1955049)
-- Dependencies: 1694
-- Data for Name: ox_data_summary_ad_zone_assoc; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2616 (class 0 OID 1955064)
-- Dependencies: 1696
-- Data for Name: ox_data_summary_channel_daily; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2617 (class 0 OID 1955077)
-- Dependencies: 1698
-- Data for Name: ox_data_summary_zone_impression_history; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2585 (class 0 OID 1954447)
-- Dependencies: 1645
-- Data for Name: ox_database_action; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2618 (class 0 OID 1955085)
-- Dependencies: 1699
-- Data for Name: ox_images; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_images (filename, contents, t_stamp) VALUES ('468x60.gif', 'GIF89a\\324\\001<\\000\\367\\000\\000\\000\\000\\000\\200\\000\\000\\000\\200\\000\\200\\200\\000\\000\\000\\200\\200\\000\\200\\000\\200\\200\\200\\200\\200\\300\\300\\300\\377\\000\\000\\000\\377\\000\\377\\377\\000\\000\\000\\377\\377\\000\\377\\000\\377\\377\\377\\377\\377\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\0003\\000\\000f\\000\\000\\231\\000\\000\\314\\000\\000\\377\\0003\\000\\00033\\0003f\\0003\\231\\0003\\314\\0003\\377\\000f\\000\\000f3\\000ff\\000f\\231\\000f\\314\\000f\\377\\000\\231\\000\\000\\2313\\000\\231f\\000\\231\\231\\000\\231\\314\\000\\231\\377\\000\\314\\000\\000\\3143\\000\\314f\\000\\314\\231\\000\\314\\314\\000\\314\\377\\000\\377\\000\\000\\3773\\000\\377f\\000\\377\\231\\000\\377\\314\\000\\377\\3773\\000\\0003\\00033\\000f3\\000\\2313\\000\\3143\\000\\37733\\00033333f33\\23133\\31433\\3773f\\0003f33ff3f\\2313f\\3143f\\3773\\231\\0003\\23133\\231f3\\231\\2313\\231\\3143\\231\\3773\\314\\0003\\31433\\314f3\\314\\2313\\314\\3143\\314\\3773\\377\\0003\\37733\\377f3\\377\\2313\\377\\3143\\377\\377f\\000\\000f\\0003f\\000ff\\000\\231f\\000\\314f\\000\\377f3\\000f33f3ff3\\231f3\\314f3\\377ff\\000ff3fffff\\231ff\\314ff\\377f\\231\\000f\\2313f\\231ff\\231\\231f\\231\\314f\\231\\377f\\314\\000f\\3143f\\314ff\\314\\231f\\314\\314f\\314\\377f\\377\\000f\\3773f\\377ff\\377\\231f\\377\\314f\\377\\377\\231\\000\\000\\231\\0003\\231\\000f\\231\\000\\231\\231\\000\\314\\231\\000\\377\\2313\\000\\23133\\2313f\\2313\\231\\2313\\314\\2313\\377\\231f\\000\\231f3\\231ff\\231f\\231\\231f\\314\\231f\\377\\231\\231\\000\\231\\2313\\231\\231f\\231\\231\\231\\231\\231\\314\\231\\231\\377\\231\\314\\000\\231\\3143\\231\\314f\\231\\314\\231\\231\\314\\314\\231\\314\\377\\231\\377\\000\\231\\3773\\231\\377f\\231\\377\\231\\231\\377\\314\\231\\377\\377\\314\\000\\000\\314\\0003\\314\\000f\\314\\000\\231\\314\\000\\314\\314\\000\\377\\3143\\000\\31433\\3143f\\3143\\231\\3143\\314\\3143\\377\\314f\\000\\314f3\\314ff\\314f\\231\\314f\\314\\314f\\377\\314\\231\\000\\314\\2313\\314\\231f\\314\\231\\231\\314\\231\\314\\314\\231\\377\\314\\314\\000\\314\\3143\\314\\314f\\314\\314\\231\\314\\314\\314\\314\\314\\377\\314\\377\\000\\314\\3773\\314\\377f\\314\\377\\231\\314\\377\\314\\314\\377\\377\\377\\000\\000\\377\\0003\\377\\000f\\377\\000\\231\\377\\000\\314\\377\\000\\377\\3773\\000\\37733\\3773f\\3773\\231\\3773\\314\\3773\\377\\377f\\000\\377f3\\377ff\\377f\\231\\377f\\314\\377f\\377\\377\\231\\000\\377\\2313\\377\\231f\\377\\231\\231\\377\\231\\314\\377\\231\\377\\377\\314\\000\\377\\3143\\377\\314f\\377\\314\\231\\377\\314\\314\\377\\314\\377\\377\\377\\000\\377\\3773\\377\\377f\\377\\377\\231\\377\\377\\314\\377\\377\\377!\\371\\004\\001\\000\\000\\020\\000,\\000\\000\\000\\000\\324\\001<\\000\\000\\010\\377\\000\\177\\344\\020Hp\\240\\301\\202\\010\\017*L\\310p\\241\\303\\206\\020\\037J\\214Hq\\242\\305\\212\\030/j\\314\\310q\\243\\307\\216 ?\\212\\014Ir\\244\\311\\222(O\\252L\\270\\262e\\312\\227.c\\302\\234)\\263&\\315\\2336s\\342\\334\\251S''\\317\\237=\\201\\012\\015Jt\\250\\321\\242H\\217*E\\232\\264\\351\\322\\247N\\243B\\235*\\265*U\\245W\\255j\\315\\312u\\253\\327\\256`\\277\\266\\024\\033\\266,\\331\\263f\\323\\242];S\\255[\\266p\\337\\312\\215K\\027j\\335\\273s\\363\\342\\335\\253\\267\\357C\\277\\200\\371\\012\\016LxpT\\303\\205\\023#^\\254\\270\\361F\\307\\220\\031K\\216L\\371\\356\\344\\313\\2253c\\336\\314U\\263g\\316\\240?\\213V\\031\\272\\364\\350\\323\\246SCD\\315Z\\265\\353\\326\\216_\\313\\206=\\273v_\\332\\270m\\353\\316\\235u\\267o\\336\\277\\203\\377\\004N\\\\\\270\\361\\342%\\217+G\\276\\2749A\\346\\320\\235K/>\\275z\\364\\353\\263\\261k\\267\\316]s\\367\\357\\333\\3033\\272\\026O\\036\\274y\\275\\347\\323\\227_\\217\\226\\275{\\365\\360\\251\\306\\237\\377\\276~Q\\373\\370\\351\\353\\247\\271\\277\\177\\376\\377#\\001(\\240\\177\\004FT\\340\\201\\003&8\\220\\202\\014"\\330\\237\\203\\015F\\030\\237\\204\\024Bh\\236\\205\\025fh\\235\\206\\034b\\330\\234\\207\\035\\206(\\234\\210$\\202\\250\\233\\211%\\246\\370\\232\\212,\\242X\\232\\213-\\306\\210\\231\\2144\\302\\270\\230\\2155\\346\\310\\227\\216<\\342H\\227\\217=\\006\\331\\036\\220D\\012\\371V\\221H\\0329\\244\\222L&\\311T\\223P:9\\234\\224TFyT\\225XZ\\031\\224\\226\\\\fi\\222\\227]\\206\\371\\030\\230d\\212\\031R\\231h\\2329\\246\\232l\\242\\231\\346\\233m2\\024''\\234t\\012T\\347\\235l\\006\\004\\000;', '2009-02-26 13:57:58');


--
-- TOC entry 2619 (class 0 OID 1955094)
-- Dependencies: 1700
-- Data for Name: ox_lb_local; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2620 (class 0 OID 1955099)
-- Dependencies: 1702
-- Data for Name: ox_log_maintenance_forecasting; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2621 (class 0 OID 1955107)
-- Dependencies: 1704
-- Data for Name: ox_log_maintenance_priority; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2622 (class 0 OID 1955115)
-- Dependencies: 1706
-- Data for Name: ox_log_maintenance_statistics; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2623 (class 0 OID 1955121)
-- Dependencies: 1707
-- Data for Name: ox_password_recovery; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2624 (class 0 OID 1955132)
-- Dependencies: 1709
-- Data for Name: ox_placement_zone_assoc; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES (1, 1, 1);
INSERT INTO ox_placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES (2, 1, 2);
INSERT INTO ox_placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES (3, 2, 3);
INSERT INTO ox_placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES (4, 2, 1);


--
-- TOC entry 2625 (class 0 OID 1955140)
-- Dependencies: 1710
-- Data for Name: ox_plugins_channel_delivery_assoc; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2626 (class 0 OID 1955153)
-- Dependencies: 1712
-- Data for Name: ox_plugins_channel_delivery_domains; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2627 (class 0 OID 1955163)
-- Dependencies: 1714
-- Data for Name: ox_plugins_channel_delivery_rules; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2628 (class 0 OID 1955177)
-- Dependencies: 1716
-- Data for Name: ox_preferences; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (1, 'default_banner_image_url', 'TRAFFICKER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (2, 'default_banner_destination_url', 'TRAFFICKER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (3, 'auto_alter_html_banners_for_click_tracking', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (4, 'default_banner_weight', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (5, 'default_campaign_weight', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (6, 'warn_email_admin', 'ADMIN');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (7, 'warn_email_admin_impression_limit', 'ADMIN');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (8, 'warn_email_admin_day_limit', 'ADMIN');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (9, 'warn_email_manager', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (10, 'warn_email_manager_impression_limit', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (11, 'warn_email_manager_day_limit', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (12, 'warn_email_advertiser', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (13, 'warn_email_advertiser_impression_limit', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (14, 'warn_email_advertiser_day_limit', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (15, 'timezone', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (16, 'tracker_default_status', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (17, 'tracker_default_type', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (18, 'tracker_link_campaigns', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (19, 'ui_show_campaign_info', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (20, 'ui_show_banner_info', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (21, 'ui_show_campaign_preview', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (22, 'ui_show_banner_html', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (23, 'ui_show_banner_preview', 'ADVERTISER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (24, 'ui_hide_inactive', '');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (25, 'ui_show_matching_banners', 'TRAFFICKER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (26, 'ui_show_matching_banners_parents', 'TRAFFICKER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (27, 'ui_novice_user', '');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (28, 'ui_week_start_day', '');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (29, 'ui_percentage_decimals', '');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (30, 'ui_column_id', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (31, 'ui_column_id_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (32, 'ui_column_id_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (33, 'ui_column_requests', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (34, 'ui_column_requests_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (35, 'ui_column_requests_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (36, 'ui_column_impressions', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (37, 'ui_column_impressions_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (38, 'ui_column_impressions_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (39, 'ui_column_clicks', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (40, 'ui_column_clicks_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (41, 'ui_column_clicks_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (42, 'ui_column_ctr', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (43, 'ui_column_ctr_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (44, 'ui_column_ctr_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (45, 'ui_column_conversions', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (46, 'ui_column_conversions_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (47, 'ui_column_conversions_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (48, 'ui_column_conversions_pending', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (49, 'ui_column_conversions_pending_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (50, 'ui_column_conversions_pending_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (51, 'ui_column_sr_views', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (52, 'ui_column_sr_views_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (53, 'ui_column_sr_views_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (54, 'ui_column_sr_clicks', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (55, 'ui_column_sr_clicks_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (56, 'ui_column_sr_clicks_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (57, 'ui_column_revenue', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (58, 'ui_column_revenue_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (59, 'ui_column_revenue_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (60, 'ui_column_cost', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (61, 'ui_column_cost_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (62, 'ui_column_cost_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (63, 'ui_column_bv', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (64, 'ui_column_bv_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (65, 'ui_column_bv_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (66, 'ui_column_num_items', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (67, 'ui_column_num_items_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (68, 'ui_column_num_items_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (69, 'ui_column_revcpc', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (70, 'ui_column_revcpc_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (71, 'ui_column_revcpc_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (72, 'ui_column_costcpc', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (73, 'ui_column_costcpc_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (74, 'ui_column_costcpc_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (75, 'ui_column_technology_cost', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (76, 'ui_column_technology_cost_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (77, 'ui_column_technology_cost_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (78, 'ui_column_income', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (79, 'ui_column_income_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (80, 'ui_column_income_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (81, 'ui_column_income_margin', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (82, 'ui_column_income_margin_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (83, 'ui_column_income_margin_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (84, 'ui_column_profit', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (85, 'ui_column_profit_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (86, 'ui_column_profit_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (87, 'ui_column_margin', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (88, 'ui_column_margin_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (89, 'ui_column_margin_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (90, 'ui_column_erpm', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (91, 'ui_column_erpm_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (92, 'ui_column_erpm_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (93, 'ui_column_erpc', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (94, 'ui_column_erpc_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (95, 'ui_column_erpc_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (96, 'ui_column_erps', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (97, 'ui_column_erps_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (98, 'ui_column_erps_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (99, 'ui_column_eipm', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (100, 'ui_column_eipm_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (101, 'ui_column_eipm_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (102, 'ui_column_eipc', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (103, 'ui_column_eipc_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (104, 'ui_column_eipc_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (105, 'ui_column_eips', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (106, 'ui_column_eips_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (107, 'ui_column_eips_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (108, 'ui_column_ecpm', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (109, 'ui_column_ecpm_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (110, 'ui_column_ecpm_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (111, 'ui_column_ecpc', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (112, 'ui_column_ecpc_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (113, 'ui_column_ecpc_rank', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (114, 'ui_column_ecps', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (115, 'ui_column_ecps_label', 'MANAGER');
INSERT INTO ox_preferences (preference_id, preference_name, account_type) VALUES (116, 'ui_column_ecps_rank', 'MANAGER');


--
-- TOC entry 2629 (class 0 OID 1955188)
-- Dependencies: 1717
-- Data for Name: ox_session; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a69fa3d84e20.51191291', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:15:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:0:"";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:10:"account_id";s:1:"1";s:6:"linked";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:0:"";s:10:"m2m_ticket";s:0:"";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:1:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:0:{}}}}', '2009-02-26 13:56:52');
INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a69fc448b553.05987456', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:13:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:19:"2009-02-26 13:57:25";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:25:"h0_gKaSlHN@Zp^0#b38KJEbw#";s:10:"m2m_ticket";s:30:"w36I-$DDWSJnR^l5U2E=8##BFhw!)K";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:1:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:0:{}}}}', '2009-02-26 13:57:34');
INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a69fcebaa6c6.87841939', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:13:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:19:"2009-02-26 13:57:35";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:25:"h0_gKaSlHN@Zp^0#b38KJEbw#";s:10:"m2m_ticket";s:30:"w36I-$DDWSJnR^l5U2E=8##BFhw!)K";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:2:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:0:{}}s:17:"campaign-zone.php";a:2:{s:9:"listorder";s:4:"name";s:14:"orderdirection";s:2:"up";}}}', '2009-02-26 13:57:46');
INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a69fdac1df41.86545664', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:13:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:19:"2009-02-26 13:57:47";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:25:"h0_gKaSlHN@Zp^0#b38KJEbw#";s:10:"m2m_ticket";s:30:"w36I-$DDWSJnR^l5U2E=8##BFhw!)K";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:1:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:1:{s:7:"clients";a:1:{i:1;a:2:{s:6:"expand";b:1;s:9:"campaigns";a:3:{i:1;a:1:{s:6:"expand";b:1;}i:3;a:1:{s:6:"expand";b:1;}i:2;a:1:{s:6:"expand";b:1;}}}}}}}}', '2009-02-26 13:57:58');
INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a69fe74a6097.45430461', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:13:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:19:"2009-02-26 13:57:59";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:25:"h0_gKaSlHN@Zp^0#b38KJEbw#";s:10:"m2m_ticket";s:30:"w36I-$DDWSJnR^l5U2E=8##BFhw!)K";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:2:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:0:{}}s:19:"affiliate-index.php";a:3:{s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";s:0:"";}}}', '2009-02-26 13:58:08');
INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('phpads49a687dd6d8535.97360330', 'a:2:{s:4:"user";O:18:"OA_Permission_User":2:{s:5:"aUser";a:13:{s:7:"user_id";s:1:"1";s:12:"contact_name";s:13:"Administrator";s:13:"email_address";s:15:"test@openx.test";s:8:"username";s:5:"openx";s:8:"language";s:2:"en";s:18:"default_account_id";s:1:"2";s:8:"comments";s:0:"";s:6:"active";s:1:"1";s:11:"sso_user_id";s:0:"";s:12:"date_created";s:19:"2009-02-26 14:56:50";s:15:"date_last_login";s:19:"2009-02-26 16:16:54";s:13:"email_updated";s:19:"2009-02-26 14:56:50";s:8:"is_admin";b:1;}s:8:"aAccount";a:7:{s:10:"account_id";s:1:"2";s:12:"account_type";s:7:"MANAGER";s:12:"account_name";s:15:"Default manager";s:12:"m2m_password";s:25:"h0_gKaSlHN@Zp^0#b38KJEbw#";s:10:"m2m_ticket";s:30:"w36I-$DDWSJnR^l5U2E=8##BFhw!)K";s:9:"entity_id";s:1:"1";s:9:"agency_id";s:1:"1";}}s:5:"prefs";a:6:{s:20:"advertiser-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";a:1:{s:7:"clients";a:1:{i:1;a:2:{s:6:"expand";b:1;s:9:"campaigns";a:3:{i:1;a:1:{s:6:"expand";b:1;}i:3;a:1:{s:6:"expand";b:1;}i:2;a:1:{s:6:"expand";b:1;}}}}}}s:19:"affiliate-index.php";a:3:{s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";s:1:"1";}s:16:"zone-include.php";a:6:{s:12:"hideinactive";b:0;s:11:"showbanners";b:1;s:13:"showcampaigns";b:0;s:9:"listorder";s:4:"name";s:14:"orderdirection";s:2:"up";s:4:"view";s:9:"placement";}s:23:"advertiser-trackers.php";a:2:{s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";}s:21:"tracker-campaigns.php";a:3:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";}s:21:"tracker-variables.php";a:1:{s:9:"trackerid";s:1:"1";}}}', '2009-02-26 16:22:00');


--
-- TOC entry 2630 (class 0 OID 1955198)
-- Dependencies: 1718
-- Data for Name: ox_targetstats; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2631 (class 0 OID 1955207)
-- Dependencies: 1720
-- Data for Name: ox_tracker_append; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2632 (class 0 OID 1955224)
-- Dependencies: 1722
-- Data for Name: ox_trackers; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_trackers (trackerid, trackername, description, clientid, viewwindow, clickwindow, blockwindow, status, type, linkcampaigns, variablemethod, appendcode, updated) VALUES (1, 'Sample Tracker', '', 1, 3, 3, 0, 4, 1, false, 'js', '', '2009-02-26 16:20:23');


--
-- TOC entry 2586 (class 0 OID 1954467)
-- Dependencies: 1647
-- Data for Name: ox_upgrade_action; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_upgrade_action (upgrade_action_id, upgrade_name, version_to, version_from, action, description, logfile, confbackup, updated) VALUES (1, 'install_2.6.4', '2.6.4', '0', 1, 'UPGRADE_COMPLETE', 'install.log', NULL, '2009-02-26 14:56:47');


--
-- TOC entry 2633 (class 0 OID 1955247)
-- Dependencies: 1724
-- Data for Name: ox_userlog; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2634 (class 0 OID 1955262)
-- Dependencies: 1726
-- Data for Name: ox_users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_users (user_id, contact_name, email_address, username, password, language, default_account_id, comments, active, sso_user_id, date_created, date_last_login, email_updated) VALUES (1, 'Administrator', 'test@openx.test', 'openx', '7a89a595cfc6cb85480202a143e37d2e', 'en', 2, NULL, 1, NULL, '2009-02-26 14:56:50', '2009-02-26 16:16:54', '2009-02-26 14:56:50');


--
-- TOC entry 2635 (class 0 OID 1955281)
-- Dependencies: 1727
-- Data for Name: ox_variable_publisher; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2636 (class 0 OID 1955288)
-- Dependencies: 1729
-- Data for Name: ox_variables; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_variables (variableid, trackerid, name, description, datatype, purpose, reject_if_empty, is_unique, unique_window, variablecode, hidden, updated) VALUES (1, 1, 'boo', 'Sample number', 'numeric', NULL, 0, 0, 0, 'var boo = \\''%%BOO_VALUE%%\\''', false, '2009-02-26 16:20:23');
INSERT INTO ox_variables (variableid, trackerid, name, description, datatype, purpose, reject_if_empty, is_unique, unique_window, variablecode, hidden, updated) VALUES (2, 1, 'foo', 'Sample string', 'string', NULL, 0, 0, 0, 'var foo = \\''%%FOO_VALUE%%\\''', false, '2009-02-26 16:20:23');


--
-- TOC entry 2637 (class 0 OID 1955310)
-- Dependencies: 1731
-- Data for Name: ox_zones; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_zones (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type, comments, cost, cost_type, cost_variable_id, technology_cost, technology_cost_type, updated, block, capping, session_capping, what, as_zone_id, is_in_ad_direct, rate, pricing) VALUES (1, 1, 'Publisher 1 - Default', '', 0, 3, '', 468, 60, '', '', '', '', 0, false, 0, '', NULL, NULL, NULL, NULL, NULL, '2009-02-26 16:17:47', 0, 0, 0, '', NULL, 0, NULL, 'CPM');
INSERT INTO ox_zones (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type, comments, cost, cost_type, cost_variable_id, technology_cost, technology_cost_type, updated, block, capping, session_capping, what, as_zone_id, is_in_ad_direct, rate, pricing) VALUES (2, 1, 'Agency Publisher 1 - Default', '', 0, 3, '', 468, 60, '', '', '', '', 0, false, 0, '', NULL, NULL, NULL, NULL, NULL, '2009-02-26 16:18:24', 0, 0, 0, '', NULL, 0, NULL, 'CPM');


--
-- TOC entry 2408 (class 2606 OID 1954491)
-- Dependencies: 1648 1648 1648
-- Name: ox_account_preference_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_account_preference_assoc
    ADD CONSTRAINT ox_account_preference_assoc_pkey PRIMARY KEY (account_id, preference_id);


--
-- TOC entry 2410 (class 2606 OID 1954496)
-- Dependencies: 1649 1649 1649
-- Name: ox_account_user_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_account_user_assoc
    ADD CONSTRAINT ox_account_user_assoc_pkey PRIMARY KEY (account_id, user_id);


--
-- TOC entry 2413 (class 2606 OID 1954503)
-- Dependencies: 1650 1650 1650 1650
-- Name: ox_account_user_permission_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_account_user_permission_assoc
    ADD CONSTRAINT ox_account_user_permission_assoc_pkey PRIMARY KEY (account_id, user_id, permission_id);


--
-- TOC entry 2416 (class 2606 OID 1954515)
-- Dependencies: 1652 1652
-- Name: ox_accounts_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_accounts
    ADD CONSTRAINT ox_accounts_pkey PRIMARY KEY (account_id);


--
-- TOC entry 2419 (class 2606 OID 1954531)
-- Dependencies: 1653 1653 1653
-- Name: ox_acls_bannerid_executionorder; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_acls
    ADD CONSTRAINT ox_acls_bannerid_executionorder UNIQUE (bannerid, executionorder);


--
-- TOC entry 2422 (class 2606 OID 1954546)
-- Dependencies: 1654 1654 1654
-- Name: ox_acls_channel_channelid_executionorder; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_acls_channel
    ADD CONSTRAINT ox_acls_channel_channelid_executionorder UNIQUE (channelid, executionorder);


--
-- TOC entry 2424 (class 2606 OID 1954554)
-- Dependencies: 1656 1656
-- Name: ox_ad_category_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_ad_category_assoc
    ADD CONSTRAINT ox_ad_category_assoc_pkey PRIMARY KEY (ad_category_assoc_id);


--
-- TOC entry 2427 (class 2606 OID 1954566)
-- Dependencies: 1658 1658
-- Name: ox_ad_zone_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_ad_zone_assoc
    ADD CONSTRAINT ox_ad_zone_assoc_pkey PRIMARY KEY (ad_zone_assoc_id);


--
-- TOC entry 2430 (class 2606 OID 1954589)
-- Dependencies: 1660 1660
-- Name: ox_affiliates_account_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_affiliates
    ADD CONSTRAINT ox_affiliates_account_id UNIQUE (account_id);


--
-- TOC entry 2435 (class 2606 OID 1954609)
-- Dependencies: 1661 1661
-- Name: ox_affiliates_extra_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_affiliates_extra
    ADD CONSTRAINT ox_affiliates_extra_pkey PRIMARY KEY (affiliateid);


--
-- TOC entry 2433 (class 2606 OID 1954586)
-- Dependencies: 1660 1660
-- Name: ox_affiliates_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_affiliates
    ADD CONSTRAINT ox_affiliates_pkey PRIMARY KEY (affiliateid);


--
-- TOC entry 2437 (class 2606 OID 1954627)
-- Dependencies: 1663 1663
-- Name: ox_agency_account_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_agency
    ADD CONSTRAINT ox_agency_account_id UNIQUE (account_id);


--
-- TOC entry 2439 (class 2606 OID 1954625)
-- Dependencies: 1663 1663
-- Name: ox_agency_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_agency
    ADD CONSTRAINT ox_agency_pkey PRIMARY KEY (agencyid);


--
-- TOC entry 2441 (class 2606 OID 1954637)
-- Dependencies: 1664 1664
-- Name: ox_application_variable_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_application_variable
    ADD CONSTRAINT ox_application_variable_pkey PRIMARY KEY (name);


--
-- TOC entry 2447 (class 2606 OID 1954653)
-- Dependencies: 1666 1666
-- Name: ox_audit_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_audit
    ADD CONSTRAINT ox_audit_pkey PRIMARY KEY (auditid);


--
-- TOC entry 2454 (class 2606 OID 1954707)
-- Dependencies: 1668 1668
-- Name: ox_banners_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_banners
    ADD CONSTRAINT ox_banners_pkey PRIMARY KEY (bannerid);


--
-- TOC entry 2457 (class 2606 OID 1954740)
-- Dependencies: 1670 1670
-- Name: ox_campaigns_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_campaigns
    ADD CONSTRAINT ox_campaigns_pkey PRIMARY KEY (campaignid);


--
-- TOC entry 2460 (class 2606 OID 1954754)
-- Dependencies: 1672 1672
-- Name: ox_campaigns_trackers_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_campaigns_trackers
    ADD CONSTRAINT ox_campaigns_trackers_pkey PRIMARY KEY (campaign_trackerid);


--
-- TOC entry 2463 (class 2606 OID 1954765)
-- Dependencies: 1674 1674
-- Name: ox_category_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_category
    ADD CONSTRAINT ox_category_pkey PRIMARY KEY (category_id);


--
-- TOC entry 2465 (class 2606 OID 1954781)
-- Dependencies: 1676 1676
-- Name: ox_channel_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_channel
    ADD CONSTRAINT ox_channel_pkey PRIMARY KEY (channelid);


--
-- TOC entry 2467 (class 2606 OID 1954804)
-- Dependencies: 1678 1678
-- Name: ox_clients_account_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_clients
    ADD CONSTRAINT ox_clients_account_id UNIQUE (account_id);


--
-- TOC entry 2470 (class 2606 OID 1954801)
-- Dependencies: 1678 1678
-- Name: ox_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_clients
    ADD CONSTRAINT ox_clients_pkey PRIMARY KEY (clientid);


--
-- TOC entry 2479 (class 2606 OID 1954866)
-- Dependencies: 1682 1682
-- Name: ox_data_intermediate_ad_connection_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_intermediate_ad_connection
    ADD CONSTRAINT ox_data_intermediate_ad_connection_pkey PRIMARY KEY (data_intermediate_ad_connection_id);


--
-- TOC entry 2475 (class 2606 OID 1954818)
-- Dependencies: 1680 1680
-- Name: ox_data_intermediate_ad_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_intermediate_ad
    ADD CONSTRAINT ox_data_intermediate_ad_pkey PRIMARY KEY (data_intermediate_ad_id);


--
-- TOC entry 2486 (class 2606 OID 1954880)
-- Dependencies: 1684 1684
-- Name: ox_data_intermediate_ad_variable_value_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_intermediate_ad_variable_value
    ADD CONSTRAINT ox_data_intermediate_ad_variable_value_pkey PRIMARY KEY (data_intermediate_ad_variable_value_id);


--
-- TOC entry 2503 (class 2606 OID 1955018)
-- Dependencies: 1689 1689 1689
-- Name: ox_data_raw_tracker_impression_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_raw_tracker_impression
    ADD CONSTRAINT ox_data_raw_tracker_impression_pkey PRIMARY KEY (server_raw_tracker_impression_id, server_raw_ip);


--
-- TOC entry 2506 (class 2606 OID 1955027)
-- Dependencies: 1690 1690 1690 1690
-- Name: ox_data_raw_tracker_variable_value_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_raw_tracker_variable_value
    ADD CONSTRAINT ox_data_raw_tracker_variable_value_pkey PRIMARY KEY (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id);


--
-- TOC entry 2510 (class 2606 OID 1955043)
-- Dependencies: 1692 1692
-- Name: ox_data_summary_ad_hourly_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_summary_ad_hourly
    ADD CONSTRAINT ox_data_summary_ad_hourly_pkey PRIMARY KEY (data_summary_ad_hourly_id);


--
-- TOC entry 2517 (class 2606 OID 1955056)
-- Dependencies: 1694 1694
-- Name: ox_data_summary_ad_zone_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_summary_ad_zone_assoc
    ADD CONSTRAINT ox_data_summary_ad_zone_assoc_pkey PRIMARY KEY (data_summary_ad_zone_assoc_id);


--
-- TOC entry 2522 (class 2606 OID 1955071)
-- Dependencies: 1696 1696
-- Name: ox_data_summary_channel_daily_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_summary_channel_daily
    ADD CONSTRAINT ox_data_summary_channel_daily_pkey PRIMARY KEY (data_summary_channel_daily_id);


--
-- TOC entry 2526 (class 2606 OID 1955082)
-- Dependencies: 1698 1698
-- Name: ox_data_summary_zone_impression_history_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_data_summary_zone_impression_history
    ADD CONSTRAINT ox_data_summary_zone_impression_history_pkey PRIMARY KEY (data_summary_zone_impression_history_id);


--
-- TOC entry 2400 (class 2606 OID 1954461)
-- Dependencies: 1645 1645
-- Name: ox_database_action_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_database_action
    ADD CONSTRAINT ox_database_action_pkey PRIMARY KEY (database_action_id);


--
-- TOC entry 2529 (class 2606 OID 1955093)
-- Dependencies: 1699 1699
-- Name: ox_images_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_images
    ADD CONSTRAINT ox_images_pkey PRIMARY KEY (filename);


--
-- TOC entry 2531 (class 2606 OID 1955104)
-- Dependencies: 1702 1702
-- Name: ox_log_maintenance_forecasting_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_log_maintenance_forecasting
    ADD CONSTRAINT ox_log_maintenance_forecasting_pkey PRIMARY KEY (log_maintenance_forecasting_id);


--
-- TOC entry 2533 (class 2606 OID 1955112)
-- Dependencies: 1704 1704
-- Name: ox_log_maintenance_priority_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_log_maintenance_priority
    ADD CONSTRAINT ox_log_maintenance_priority_pkey PRIMARY KEY (log_maintenance_priority_id);


--
-- TOC entry 2535 (class 2606 OID 1955120)
-- Dependencies: 1706 1706
-- Name: ox_log_maintenance_statistics_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_log_maintenance_statistics
    ADD CONSTRAINT ox_log_maintenance_statistics_pkey PRIMARY KEY (log_maintenance_statistics_id);


--
-- TOC entry 2537 (class 2606 OID 1955127)
-- Dependencies: 1707 1707 1707
-- Name: ox_password_recovery_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_password_recovery
    ADD CONSTRAINT ox_password_recovery_pkey PRIMARY KEY (user_type, user_id);


--
-- TOC entry 2539 (class 2606 OID 1955129)
-- Dependencies: 1707 1707
-- Name: ox_password_recovery_recovery_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_password_recovery
    ADD CONSTRAINT ox_password_recovery_recovery_id UNIQUE (recovery_id);


--
-- TOC entry 2541 (class 2606 OID 1955137)
-- Dependencies: 1709 1709
-- Name: ox_placement_zone_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_placement_zone_assoc
    ADD CONSTRAINT ox_placement_zone_assoc_pkey PRIMARY KEY (placement_zone_assoc_id);


--
-- TOC entry 2546 (class 2606 OID 1955147)
-- Dependencies: 1710 1710 1710
-- Name: ox_plugins_channel_delivery_assoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_plugins_channel_delivery_assoc
    ADD CONSTRAINT ox_plugins_channel_delivery_assoc_pkey PRIMARY KEY (rule_id, domain_id);


--
-- TOC entry 2551 (class 2606 OID 1955159)
-- Dependencies: 1712 1712
-- Name: ox_plugins_channel_delivery_domains_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_plugins_channel_delivery_domains
    ADD CONSTRAINT ox_plugins_channel_delivery_domains_pkey PRIMARY KEY (domain_id);


--
-- TOC entry 2553 (class 2606 OID 1955174)
-- Dependencies: 1714 1714
-- Name: ox_plugins_channel_delivery_rules_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_plugins_channel_delivery_rules
    ADD CONSTRAINT ox_plugins_channel_delivery_rules_pkey PRIMARY KEY (rule_id);


--
-- TOC entry 2556 (class 2606 OID 1955184)
-- Dependencies: 1716 1716
-- Name: ox_preferences_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_preferences
    ADD CONSTRAINT ox_preferences_pkey PRIMARY KEY (preference_id);


--
-- TOC entry 2558 (class 2606 OID 1955186)
-- Dependencies: 1716 1716
-- Name: ox_preferences_preference_name; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_preferences
    ADD CONSTRAINT ox_preferences_preference_name UNIQUE (preference_name);


--
-- TOC entry 2560 (class 2606 OID 1955197)
-- Dependencies: 1717 1717
-- Name: ox_session_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_session
    ADD CONSTRAINT ox_session_pkey PRIMARY KEY (sessionid);


--
-- TOC entry 2562 (class 2606 OID 1955220)
-- Dependencies: 1720 1720
-- Name: ox_tracker_append_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_tracker_append
    ADD CONSTRAINT ox_tracker_append_pkey PRIMARY KEY (tracker_append_id);


--
-- TOC entry 2566 (class 2606 OID 1955243)
-- Dependencies: 1722 1722
-- Name: ox_trackers_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_trackers
    ADD CONSTRAINT ox_trackers_pkey PRIMARY KEY (trackerid);


--
-- TOC entry 2405 (class 2606 OID 1954481)
-- Dependencies: 1647 1647
-- Name: ox_upgrade_action_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_upgrade_action
    ADD CONSTRAINT ox_upgrade_action_pkey PRIMARY KEY (upgrade_action_id);


--
-- TOC entry 2568 (class 2606 OID 1955259)
-- Dependencies: 1724 1724
-- Name: ox_userlog_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_userlog
    ADD CONSTRAINT ox_userlog_pkey PRIMARY KEY (userlogid);


--
-- TOC entry 2570 (class 2606 OID 1955276)
-- Dependencies: 1726 1726
-- Name: ox_users_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_users
    ADD CONSTRAINT ox_users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 2572 (class 2606 OID 1955280)
-- Dependencies: 1726 1726
-- Name: ox_users_sso_user_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_users
    ADD CONSTRAINT ox_users_sso_user_id UNIQUE (sso_user_id);


--
-- TOC entry 2574 (class 2606 OID 1955278)
-- Dependencies: 1726 1726
-- Name: ox_users_username; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_users
    ADD CONSTRAINT ox_users_username UNIQUE (username);


--
-- TOC entry 2576 (class 2606 OID 1955285)
-- Dependencies: 1727 1727 1727
-- Name: ox_variable_publisher_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_variable_publisher
    ADD CONSTRAINT ox_variable_publisher_pkey PRIMARY KEY (variable_id, publisher_id);


--
-- TOC entry 2579 (class 2606 OID 1955305)
-- Dependencies: 1729 1729
-- Name: ox_variables_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_variables
    ADD CONSTRAINT ox_variables_pkey PRIMARY KEY (variableid);


--
-- TOC entry 2583 (class 2606 OID 1955342)
-- Dependencies: 1731 1731
-- Name: ox_zones_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_zones
    ADD CONSTRAINT ox_zones_pkey PRIMARY KEY (zoneid);


--
-- TOC entry 2411 (class 1259 OID 1954497)
-- Dependencies: 1649
-- Name: ox_account_user_assoc_user_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_account_user_assoc_user_id ON ox_account_user_assoc USING btree (user_id);


--
-- TOC entry 2414 (class 1259 OID 1954516)
-- Dependencies: 1652
-- Name: ox_accounts_account_type; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_accounts_account_type ON ox_accounts USING btree (account_type);


--
-- TOC entry 2417 (class 1259 OID 1954529)
-- Dependencies: 1653
-- Name: ox_acls_bannerid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_acls_bannerid ON ox_acls USING btree (bannerid);


--
-- TOC entry 2420 (class 1259 OID 1954544)
-- Dependencies: 1654
-- Name: ox_acls_channel_channelid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_acls_channel_channelid ON ox_acls_channel USING btree (channelid);


--
-- TOC entry 2425 (class 1259 OID 1954568)
-- Dependencies: 1658
-- Name: ox_ad_zone_assoc_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_ad_zone_assoc_ad_id ON ox_ad_zone_assoc USING btree (ad_id);


--
-- TOC entry 2428 (class 1259 OID 1954567)
-- Dependencies: 1658
-- Name: ox_ad_zone_assoc_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_ad_zone_assoc_zone_id ON ox_ad_zone_assoc USING btree (zone_id);


--
-- TOC entry 2431 (class 1259 OID 1954587)
-- Dependencies: 1660
-- Name: ox_affiliates_agencyid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_affiliates_agencyid ON ox_affiliates USING btree (agencyid);


--
-- TOC entry 2442 (class 1259 OID 1954659)
-- Dependencies: 1666
-- Name: ox_audit_account_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_account_id ON ox_audit USING btree (account_id);


--
-- TOC entry 2443 (class 1259 OID 1954660)
-- Dependencies: 1666
-- Name: ox_audit_advertiser_account_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_advertiser_account_id ON ox_audit USING btree (advertiser_account_id);


--
-- TOC entry 2444 (class 1259 OID 1954658)
-- Dependencies: 1666 1666
-- Name: ox_audit_context_actionid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_context_actionid ON ox_audit USING btree (context, actionid);


--
-- TOC entry 2445 (class 1259 OID 1954654)
-- Dependencies: 1666 1666
-- Name: ox_audit_parentid_contextid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_parentid_contextid ON ox_audit USING btree (parentid, contextid);


--
-- TOC entry 2448 (class 1259 OID 1954655)
-- Dependencies: 1666
-- Name: ox_audit_updated; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_updated ON ox_audit USING btree (updated);


--
-- TOC entry 2449 (class 1259 OID 1954657)
-- Dependencies: 1666
-- Name: ox_audit_username; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_username ON ox_audit USING btree (username);


--
-- TOC entry 2450 (class 1259 OID 1954656)
-- Dependencies: 1666
-- Name: ox_audit_usertype; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_usertype ON ox_audit USING btree (usertype);


--
-- TOC entry 2451 (class 1259 OID 1954661)
-- Dependencies: 1666
-- Name: ox_audit_website_account_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_audit_website_account_id ON ox_audit USING btree (website_account_id);


--
-- TOC entry 2452 (class 1259 OID 1954708)
-- Dependencies: 1668
-- Name: ox_banners_campaignid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_banners_campaignid ON ox_banners USING btree (campaignid);


--
-- TOC entry 2455 (class 1259 OID 1954741)
-- Dependencies: 1670
-- Name: ox_campaigns_clientid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_campaigns_clientid ON ox_campaigns USING btree (clientid);


--
-- TOC entry 2458 (class 1259 OID 1954755)
-- Dependencies: 1672
-- Name: ox_campaigns_trackers_campaignid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_campaigns_trackers_campaignid ON ox_campaigns_trackers USING btree (campaignid);


--
-- TOC entry 2461 (class 1259 OID 1954756)
-- Dependencies: 1672
-- Name: ox_campaigns_trackers_trackerid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_campaigns_trackers_trackerid ON ox_campaigns_trackers USING btree (trackerid);


--
-- TOC entry 2468 (class 1259 OID 1954802)
-- Dependencies: 1678
-- Name: ox_clients_agencyid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_clients_agencyid ON ox_clients USING btree (agencyid);


--
-- TOC entry 2471 (class 1259 OID 1954819)
-- Dependencies: 1680 1680
-- Name: ox_data_intermediate_ad_ad_id_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_ad_id_date_time ON ox_data_intermediate_ad USING btree (ad_id, date_time);


--
-- TOC entry 2477 (class 1259 OID 1954869)
-- Dependencies: 1682
-- Name: ox_data_intermediate_ad_connection_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_connection_ad_id ON ox_data_intermediate_ad_connection USING btree (ad_id);


--
-- TOC entry 2480 (class 1259 OID 1954867)
-- Dependencies: 1682
-- Name: ox_data_intermediate_ad_connection_tracker_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_connection_tracker_date_time ON ox_data_intermediate_ad_connection USING btree (tracker_date_time);


--
-- TOC entry 2481 (class 1259 OID 1954868)
-- Dependencies: 1682
-- Name: ox_data_intermediate_ad_connection_tracker_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_connection_tracker_id ON ox_data_intermediate_ad_connection USING btree (tracker_id);


--
-- TOC entry 2482 (class 1259 OID 1954871)
-- Dependencies: 1682
-- Name: ox_data_intermediate_ad_connection_viewer_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_connection_viewer_id ON ox_data_intermediate_ad_connection USING btree (viewer_id);


--
-- TOC entry 2483 (class 1259 OID 1954870)
-- Dependencies: 1682
-- Name: ox_data_intermediate_ad_connection_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_connection_zone_id ON ox_data_intermediate_ad_connection USING btree (zone_id);


--
-- TOC entry 2472 (class 1259 OID 1954821)
-- Dependencies: 1680
-- Name: ox_data_intermediate_ad_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_date_time ON ox_data_intermediate_ad USING btree (date_time);


--
-- TOC entry 2473 (class 1259 OID 1954822)
-- Dependencies: 1680
-- Name: ox_data_intermediate_ad_interval_start; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_interval_start ON ox_data_intermediate_ad USING btree (interval_start);


--
-- TOC entry 2484 (class 1259 OID 1954881)
-- Dependencies: 1684
-- Name: ox_data_intermediate_ad_variable_value_data_intermediate_ad_con; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_variable_value_data_intermediate_ad_con ON ox_data_intermediate_ad_variable_value USING btree (data_intermediate_ad_connection_id);


--
-- TOC entry 2487 (class 1259 OID 1954883)
-- Dependencies: 1684
-- Name: ox_data_intermediate_ad_variable_value_tracker_value; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_variable_value_tracker_value ON ox_data_intermediate_ad_variable_value USING btree (value);


--
-- TOC entry 2488 (class 1259 OID 1954882)
-- Dependencies: 1684
-- Name: ox_data_intermediate_ad_variable_value_tracker_variable_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_variable_value_tracker_variable_id ON ox_data_intermediate_ad_variable_value USING btree (tracker_variable_id);


--
-- TOC entry 2476 (class 1259 OID 1954820)
-- Dependencies: 1680 1680
-- Name: ox_data_intermediate_ad_zone_id_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_intermediate_ad_zone_id_date_time ON ox_data_intermediate_ad USING btree (zone_id, date_time);


--
-- TOC entry 2489 (class 1259 OID 1954918)
-- Dependencies: 1685
-- Name: ox_data_raw_ad_click_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_click_ad_id ON ox_data_raw_ad_click USING btree (ad_id);


--
-- TOC entry 2490 (class 1259 OID 1954917)
-- Dependencies: 1685
-- Name: ox_data_raw_ad_click_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_click_date_time ON ox_data_raw_ad_click USING btree (date_time);


--
-- TOC entry 2491 (class 1259 OID 1954916)
-- Dependencies: 1685
-- Name: ox_data_raw_ad_click_viewer_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_click_viewer_id ON ox_data_raw_ad_click USING btree (viewer_id);


--
-- TOC entry 2492 (class 1259 OID 1954919)
-- Dependencies: 1685
-- Name: ox_data_raw_ad_click_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_click_zone_id ON ox_data_raw_ad_click USING btree (zone_id);


--
-- TOC entry 2493 (class 1259 OID 1954954)
-- Dependencies: 1686
-- Name: ox_data_raw_ad_impression_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_impression_ad_id ON ox_data_raw_ad_impression USING btree (ad_id);


--
-- TOC entry 2494 (class 1259 OID 1954953)
-- Dependencies: 1686
-- Name: ox_data_raw_ad_impression_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_impression_date_time ON ox_data_raw_ad_impression USING btree (date_time);


--
-- TOC entry 2495 (class 1259 OID 1954952)
-- Dependencies: 1686
-- Name: ox_data_raw_ad_impression_viewer_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_impression_viewer_id ON ox_data_raw_ad_impression USING btree (viewer_id);


--
-- TOC entry 2496 (class 1259 OID 1954955)
-- Dependencies: 1686
-- Name: ox_data_raw_ad_impression_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_impression_zone_id ON ox_data_raw_ad_impression USING btree (zone_id);


--
-- TOC entry 2497 (class 1259 OID 1954979)
-- Dependencies: 1687
-- Name: ox_data_raw_ad_request_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_request_ad_id ON ox_data_raw_ad_request USING btree (ad_id);


--
-- TOC entry 2498 (class 1259 OID 1954978)
-- Dependencies: 1687
-- Name: ox_data_raw_ad_request_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_request_date_time ON ox_data_raw_ad_request USING btree (date_time);


--
-- TOC entry 2499 (class 1259 OID 1954977)
-- Dependencies: 1687
-- Name: ox_data_raw_ad_request_viewer_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_request_viewer_id ON ox_data_raw_ad_request USING btree (viewer_id);


--
-- TOC entry 2500 (class 1259 OID 1954980)
-- Dependencies: 1687
-- Name: ox_data_raw_ad_request_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_ad_request_zone_id ON ox_data_raw_ad_request USING btree (zone_id);


--
-- TOC entry 2501 (class 1259 OID 1955020)
-- Dependencies: 1689
-- Name: ox_data_raw_tracker_impression_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_tracker_impression_date_time ON ox_data_raw_tracker_impression USING btree (date_time);


--
-- TOC entry 2504 (class 1259 OID 1955019)
-- Dependencies: 1689
-- Name: ox_data_raw_tracker_impression_viewer_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_raw_tracker_impression_viewer_id ON ox_data_raw_tracker_impression USING btree (viewer_id);


--
-- TOC entry 2507 (class 1259 OID 1955045)
-- Dependencies: 1692 1692
-- Name: ox_data_summary_ad_hourly_ad_id_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_hourly_ad_id_date_time ON ox_data_summary_ad_hourly USING btree (ad_id, date_time);


--
-- TOC entry 2508 (class 1259 OID 1955044)
-- Dependencies: 1692
-- Name: ox_data_summary_ad_hourly_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_hourly_date_time ON ox_data_summary_ad_hourly USING btree (date_time);


--
-- TOC entry 2511 (class 1259 OID 1955046)
-- Dependencies: 1692 1692
-- Name: ox_data_summary_ad_hourly_zone_id_date_time; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_hourly_zone_id_date_time ON ox_data_summary_ad_hourly USING btree (zone_id, date_time);


--
-- TOC entry 2512 (class 1259 OID 1955059)
-- Dependencies: 1694
-- Name: ox_data_summary_ad_zone_assoc_ad_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_zone_assoc_ad_id ON ox_data_summary_ad_zone_assoc USING btree (ad_id);


--
-- TOC entry 2513 (class 1259 OID 1955061)
-- Dependencies: 1694
-- Name: ox_data_summary_ad_zone_assoc_expired; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_zone_assoc_expired ON ox_data_summary_ad_zone_assoc USING btree (expired);


--
-- TOC entry 2514 (class 1259 OID 1955058)
-- Dependencies: 1694
-- Name: ox_data_summary_ad_zone_assoc_interval_end; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_zone_assoc_interval_end ON ox_data_summary_ad_zone_assoc USING btree (interval_end);


--
-- TOC entry 2515 (class 1259 OID 1955057)
-- Dependencies: 1694
-- Name: ox_data_summary_ad_zone_assoc_interval_start; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_zone_assoc_interval_start ON ox_data_summary_ad_zone_assoc USING btree (interval_start);


--
-- TOC entry 2518 (class 1259 OID 1955060)
-- Dependencies: 1694
-- Name: ox_data_summary_ad_zone_assoc_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_ad_zone_assoc_zone_id ON ox_data_summary_ad_zone_assoc USING btree (zone_id);


--
-- TOC entry 2519 (class 1259 OID 1955073)
-- Dependencies: 1696
-- Name: ox_data_summary_channel_daily_channel_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_channel_daily_channel_id ON ox_data_summary_channel_daily USING btree (channel_id);


--
-- TOC entry 2520 (class 1259 OID 1955072)
-- Dependencies: 1696
-- Name: ox_data_summary_channel_daily_day; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_channel_daily_day ON ox_data_summary_channel_daily USING btree (day);


--
-- TOC entry 2523 (class 1259 OID 1955074)
-- Dependencies: 1696
-- Name: ox_data_summary_channel_daily_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_channel_daily_zone_id ON ox_data_summary_channel_daily USING btree (zone_id);


--
-- TOC entry 2524 (class 1259 OID 1955083)
-- Dependencies: 1698
-- Name: ox_data_summary_zone_impression_history_operation_interval_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_zone_impression_history_operation_interval_id ON ox_data_summary_zone_impression_history USING btree (operation_interval_id);


--
-- TOC entry 2527 (class 1259 OID 1955084)
-- Dependencies: 1698
-- Name: ox_data_summary_zone_impression_history_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_data_summary_zone_impression_history_zone_id ON ox_data_summary_zone_impression_history USING btree (zone_id);


--
-- TOC entry 2401 (class 1259 OID 1954463)
-- Dependencies: 1645 1645 1645 1645
-- Name: ox_database_action_schema_version_timing_action; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_database_action_schema_version_timing_action ON ox_database_action USING btree (schema_name, version, timing, action);


--
-- TOC entry 2402 (class 1259 OID 1954464)
-- Dependencies: 1645
-- Name: ox_database_action_updated; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_database_action_updated ON ox_database_action USING btree (updated);


--
-- TOC entry 2403 (class 1259 OID 1954462)
-- Dependencies: 1645 1645
-- Name: ox_database_action_upgrade_action_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_database_action_upgrade_action_id ON ox_database_action USING btree (upgrade_action_id, database_action_id);


--
-- TOC entry 2542 (class 1259 OID 1955139)
-- Dependencies: 1709
-- Name: ox_placement_zone_assoc_placement_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_placement_zone_assoc_placement_id ON ox_placement_zone_assoc USING btree (placement_id);


--
-- TOC entry 2543 (class 1259 OID 1955138)
-- Dependencies: 1709
-- Name: ox_placement_zone_assoc_zone_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_placement_zone_assoc_zone_id ON ox_placement_zone_assoc USING btree (zone_id);


--
-- TOC entry 2544 (class 1259 OID 1955148)
-- Dependencies: 1710
-- Name: ox_plugins_channel_delivery_assoc_domain_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_plugins_channel_delivery_assoc_domain_id ON ox_plugins_channel_delivery_assoc USING btree (domain_id);


--
-- TOC entry 2547 (class 1259 OID 1955149)
-- Dependencies: 1710
-- Name: ox_plugins_channel_delivery_assoc_rule_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_plugins_channel_delivery_assoc_rule_id ON ox_plugins_channel_delivery_assoc USING btree (rule_id);


--
-- TOC entry 2548 (class 1259 OID 1955150)
-- Dependencies: 1710
-- Name: ox_plugins_channel_delivery_assoc_rule_order; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_plugins_channel_delivery_assoc_rule_order ON ox_plugins_channel_delivery_assoc USING btree (rule_order);


--
-- TOC entry 2549 (class 1259 OID 1955160)
-- Dependencies: 1712
-- Name: ox_plugins_channel_delivery_domains_domain_name; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_plugins_channel_delivery_domains_domain_name ON ox_plugins_channel_delivery_domains USING btree (domain_name);


--
-- TOC entry 2554 (class 1259 OID 1955187)
-- Dependencies: 1716
-- Name: ox_preferences_account_type; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_preferences_account_type ON ox_preferences USING btree (account_type);


--
-- TOC entry 2563 (class 1259 OID 1955221)
-- Dependencies: 1720 1720
-- Name: ox_tracker_append_tracker_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_tracker_append_tracker_id ON ox_tracker_append USING btree (tracker_id, rank);


--
-- TOC entry 2564 (class 1259 OID 1955244)
-- Dependencies: 1722
-- Name: ox_trackers_clientid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_trackers_clientid ON ox_trackers USING btree (clientid);


--
-- TOC entry 2406 (class 1259 OID 1954482)
-- Dependencies: 1647
-- Name: ox_upgrade_action_updated; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_upgrade_action_updated ON ox_upgrade_action USING btree (updated);


--
-- TOC entry 2577 (class 1259 OID 1955306)
-- Dependencies: 1729
-- Name: ox_variables_is_unique; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_variables_is_unique ON ox_variables USING btree (is_unique);


--
-- TOC entry 2580 (class 1259 OID 1955307)
-- Dependencies: 1729
-- Name: ox_variables_trackerid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_variables_trackerid ON ox_variables USING btree (trackerid);


--
-- TOC entry 2581 (class 1259 OID 1955344)
-- Dependencies: 1731
-- Name: ox_zones_affiliateid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_zones_affiliateid ON ox_zones USING btree (affiliateid);


--
-- TOC entry 2584 (class 1259 OID 1955343)
-- Dependencies: 1731 1731
-- Name: ox_zones_zonenameid; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_zones_zonenameid ON ox_zones USING btree (zonename, zoneid);


--
-- TOC entry 2642 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-03-06 14:13:30 CET

--
-- PostgreSQL database dump complete
--

