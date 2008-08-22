--
-- PostgreSQL database dump
--

-- Started on 2008-08-13 12:02:10 CEST

-- SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1527 (class 1259 OID 939204)
-- Dependencies: 1867 1868 1869 1870 1871 3
-- Name: ox_acls; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_acls (
    bannerid integer DEFAULT 0 NOT NULL,
    logical character varying(3) DEFAULT 'and'::character varying NOT NULL,
    type character varying(16) DEFAULT ''::character varying NOT NULL,
    comparison character varying(2) DEFAULT '=='::character varying NOT NULL,
    executionorder integer DEFAULT 0 NOT NULL,
    data text NOT NULL
);


--
-- TOC entry 1525 (class 1259 OID 939180)
-- Dependencies: 1855 1856 1857 1858 1859 1860 3
-- Name: ox_adclicks; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_adclicks (
    bannerid integer DEFAULT 0 NOT NULL,
    zoneid integer DEFAULT 0 NOT NULL,
    t_stamp timestamp(0) with time zone DEFAULT now() NOT NULL,
    host character varying(255) DEFAULT ''::character varying NOT NULL,
    source character varying(50) DEFAULT ''::character varying NOT NULL,
    country character varying(2) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 1528 (class 1259 OID 939222)
-- Dependencies: 1872 1873 1874 1875 1876 1877 1878 3
-- Name: ox_adstats; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_adstats (
    views integer DEFAULT 0 NOT NULL,
    clicks integer DEFAULT 0 NOT NULL,
    day date DEFAULT now() NOT NULL,
    hour integer DEFAULT 0 NOT NULL,
    bannerid integer DEFAULT 0 NOT NULL,
    zoneid integer DEFAULT 0 NOT NULL,
    source character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 1526 (class 1259 OID 939192)
-- Dependencies: 1861 1862 1863 1864 1865 1866 3
-- Name: ox_adviews; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_adviews (
    bannerid integer DEFAULT 0 NOT NULL,
    zoneid integer DEFAULT 0 NOT NULL,
    t_stamp timestamp(0) with time zone DEFAULT now() NOT NULL,
    host character varying(255) DEFAULT ''::character varying NOT NULL,
    source character varying(50) DEFAULT ''::character varying NOT NULL,
    country character varying(2) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 1521 (class 1259 OID 939137)
-- Dependencies: 3
-- Name: ox_affiliates_affiliateid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_affiliates_affiliateid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2017 (class 0 OID 0)
-- Dependencies: 1521
-- Name: ox_affiliates_affiliateid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_affiliates_affiliateid_seq', 1, true);


--
-- TOC entry 1522 (class 1259 OID 939139)
-- Dependencies: 1839 1840 1841 1842 3
-- Name: ox_affiliates; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_affiliates (
    affiliateid integer DEFAULT nextval('ox_affiliates_affiliateid_seq'::regclass) NOT NULL,
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    website character varying(255),
    contact character varying(255),
    email character varying(64) DEFAULT ''::character varying NOT NULL,
    username character varying(64),
    password character varying(64),
    permissions smallint,
    language character varying(64),
    publiczones boolean DEFAULT false NOT NULL
);


--
-- TOC entry 1519 (class 1259 OID 939091)
-- Dependencies: 3
-- Name: ox_banners_bannerid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_banners_bannerid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2020 (class 0 OID 0)
-- Dependencies: 1519
-- Name: ox_banners_bannerid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_banners_bannerid_seq', 3, true);


--
-- TOC entry 1520 (class 1259 OID 939093)
-- Dependencies: 1809 1810 1811 1812 1813 1814 1815 1816 1817 1818 1819 1820 1821 1822 1823 1824 1825 1826 1827 1828 1829 1830 1831 1832 1833 1834 1835 1836 1837 1838 3
-- Name: ox_banners; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_banners (
    bannerid integer DEFAULT nextval('ox_banners_bannerid_seq'::regclass) NOT NULL,
    clientid integer DEFAULT 0 NOT NULL,
    active boolean DEFAULT true NOT NULL,
    priority integer DEFAULT 0 NOT NULL,
    contenttype character varying(4) DEFAULT 'gif'::character varying NOT NULL,
    pluginversion integer DEFAULT 0 NOT NULL,
    storagetype character varying(10) DEFAULT 'sql'::character varying NOT NULL,
    filename character varying(255) DEFAULT ''::character varying NOT NULL,
    imageurl character varying(255) DEFAULT ''::character varying NOT NULL,
    htmltemplate text DEFAULT ''::text NOT NULL,
    htmlcache text DEFAULT ''::text NOT NULL,
    width smallint DEFAULT 0 NOT NULL,
    height smallint DEFAULT 0 NOT NULL,
    weight smallint DEFAULT 1 NOT NULL,
    seq smallint DEFAULT 0 NOT NULL,
    target character varying(24) DEFAULT ''::character varying NOT NULL,
    url character varying(255) DEFAULT ''::character varying NOT NULL,
    alt character varying(255) DEFAULT ''::character varying NOT NULL,
    status character varying(255) DEFAULT ''::character varying NOT NULL,
    keyword character varying(255) DEFAULT ''::character varying NOT NULL,
    bannertext text DEFAULT ''::text NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    autohtml boolean DEFAULT true NOT NULL,
    block integer DEFAULT 0 NOT NULL,
    capping integer DEFAULT 0 NOT NULL,
    compiledlimitation text DEFAULT ''::text NOT NULL,
    append text DEFAULT ''::text NOT NULL,
    appendtype smallint DEFAULT 0 NOT NULL,
    bannertype smallint DEFAULT 0 NOT NULL,
    transparent boolean DEFAULT false NOT NULL
);


--
-- TOC entry 1513 (class 1259 OID 939038)
-- Dependencies: 1798 3
-- Name: ox_cache; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_cache (
    cacheid character varying(255) NOT NULL,
    content bytea NOT NULL,
    contentsize integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1516 (class 1259 OID 939062)
-- Dependencies: 3
-- Name: ox_clients_clientid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_clients_clientid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2024 (class 0 OID 0)
-- Dependencies: 1516
-- Name: ox_clients_clientid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_clients_clientid_seq', 4, true);


--
-- TOC entry 1517 (class 1259 OID 939064)
-- Dependencies: 1804 1805 1806 1807 1808 3
-- Name: ox_clients; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_clients (
    clientid integer DEFAULT nextval('ox_clients_clientid_seq'::regclass) NOT NULL,
    clientname character varying(255) DEFAULT ''::character varying NOT NULL,
    contact character varying(255),
    email character varying(64),
    views integer,
    clicks integer,
    clientusername character varying(64),
    clientpassword character varying(64),
    expire date,
    activate date,
    permissions smallint,
    language character varying(64),
    active boolean,
    weight smallint DEFAULT 1,
    target integer DEFAULT 0,
    parent integer,
    report boolean,
    reportinterval integer DEFAULT 7,
    reportlastdate date,
    reportdeactivate boolean
);


--
-- TOC entry 1531 (class 1259 OID 939257)
-- Dependencies: 1887 1888 1889 1890 1891 1892 1893 1894 1895 1896 1897 1898 1899 1900 1901 1902 1903 1904 1905 1906 1907 1908 1909 1910 1911 1912 1913 1914 1915 1916 1917 1918 1919 1920 1921 1922 1923 1924 1925 1926 1927 1928 1929 1930 1931 1932 1933 1934 1935 1936 1937 1938 1939 1940 1941 1942 1943 1944 1945 1946 1947 1948 1949 1950 1951 1952 1953 3
-- Name: ox_config; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_config (
    configid integer DEFAULT 0 NOT NULL,
    config_version real NOT NULL,
    instance_id character varying(64) DEFAULT ''::character varying NOT NULL,
    my_header text DEFAULT ''::text NOT NULL,
    my_footer text DEFAULT ''::text NOT NULL,
    table_border_color character(7) DEFAULT '#000099'::bpchar NOT NULL,
    table_back_color character(7) DEFAULT '#CCCCCC'::bpchar NOT NULL,
    table_back_color_alternative character(7) DEFAULT '#F7F7F7'::bpchar NOT NULL,
    main_back_color character(7) DEFAULT '#FFFFFF'::bpchar NOT NULL,
    language character varying(32) DEFAULT 'english'::character varying NOT NULL,
    name character varying(32) DEFAULT ''::character varying NOT NULL,
    company_name character varying(255) DEFAULT 'mysite.com'::character varying NOT NULL,
    override_gd_imageformat character varying(4) DEFAULT ''::character varying NOT NULL,
    begin_of_week smallint DEFAULT 1 NOT NULL,
    percentage_decimals smallint DEFAULT 2 NOT NULL,
    type_sql_allow boolean DEFAULT true NOT NULL,
    type_url_allow boolean DEFAULT true NOT NULL,
    type_web_allow boolean DEFAULT false NOT NULL,
    type_html_allow boolean DEFAULT true NOT NULL,
    type_txt_allow boolean DEFAULT true NOT NULL,
    type_web_mode smallint DEFAULT 0 NOT NULL,
    type_web_url character varying(255) DEFAULT ''::character varying NOT NULL,
    type_web_dir character varying(255) DEFAULT ''::character varying NOT NULL,
    type_web_ftp character varying(255) DEFAULT ''::character varying NOT NULL,
    admin character varying(64) DEFAULT 'phpadsuser'::character varying NOT NULL,
    admin_pw character varying(64) DEFAULT 'phpadspass'::character varying NOT NULL,
    admin_fullname character varying(255) DEFAULT 'Your Name'::character varying NOT NULL,
    admin_email character varying(64) DEFAULT 'your@email.com'::character varying NOT NULL,
    admin_email_headers character varying(64) DEFAULT ''::character varying NOT NULL,
    admin_novice boolean DEFAULT true NOT NULL,
    default_banner_weight smallint DEFAULT 1::smallint NOT NULL,
    default_campaign_weight smallint DEFAULT 1::smallint NOT NULL,
    client_welcome boolean DEFAULT true NOT NULL,
    client_welcome_msg text DEFAULT ''::text NOT NULL,
    content_gzip_compression boolean DEFAULT false NOT NULL,
    userlog_email boolean DEFAULT true NOT NULL,
    userlog_priority boolean DEFAULT true NOT NULL,
    userlog_autoclean boolean DEFAULT true NOT NULL,
    gui_show_campaign_info boolean DEFAULT true NOT NULL,
    gui_show_campaign_preview boolean DEFAULT false NOT NULL,
    gui_show_banner_info boolean DEFAULT true NOT NULL,
    gui_show_banner_preview boolean DEFAULT true NOT NULL,
    gui_show_banner_html boolean DEFAULT false NOT NULL,
    gui_show_matching boolean DEFAULT true NOT NULL,
    gui_show_parents boolean DEFAULT false NOT NULL,
    gui_hide_inactive boolean DEFAULT false NOT NULL,
    gui_link_compact_limit integer DEFAULT 50 NOT NULL,
    qmail_patch boolean DEFAULT false NOT NULL,
    updates_enabled boolean DEFAULT true NOT NULL,
    updates_last_seen real DEFAULT 0 NOT NULL,
    updates_cache text DEFAULT ''::text NOT NULL,
    updates_timestamp integer DEFAULT 0 NOT NULL,
    updates_dev_builds boolean DEFAULT false NOT NULL,
    allow_invocation_plain boolean DEFAULT false NOT NULL,
    allow_invocation_js boolean DEFAULT true NOT NULL,
    allow_invocation_frame boolean DEFAULT false NOT NULL,
    allow_invocation_xmlrpc boolean DEFAULT false NOT NULL,
    allow_invocation_local boolean DEFAULT true NOT NULL,
    allow_invocation_interstitial boolean DEFAULT true NOT NULL,
    allow_invocation_popup boolean DEFAULT true NOT NULL,
    auto_clean_tables boolean DEFAULT false NOT NULL,
    auto_clean_tables_interval smallint DEFAULT 5 NOT NULL,
    auto_clean_userlog boolean DEFAULT false NOT NULL,
    auto_clean_userlog_interval smallint DEFAULT 5 NOT NULL,
    auto_clean_tables_vacuum boolean DEFAULT true NOT NULL,
    autotarget_factor double precision DEFAULT -1 NOT NULL,
    maintenance_timestamp integer DEFAULT 0 NOT NULL,
    maintenance_cron_timestamp integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 1518 (class 1259 OID 939083)
-- Dependencies: 3
-- Name: ox_images; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_images (
    filename character varying(128) NOT NULL,
    contents bytea NOT NULL,
    t_stamp timestamp(0) with time zone
);


--
-- TOC entry 1529 (class 1259 OID 939236)
-- Dependencies: 1879 1880 1881 3
-- Name: ox_session; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_session (
    sessionid character varying(32) DEFAULT ''::character varying NOT NULL,
    sessiondata text DEFAULT ''::text NOT NULL,
    lastused timestamp(0) with time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1530 (class 1259 OID 939247)
-- Dependencies: 1882 1883 1884 1885 1886 3
-- Name: ox_targetstats; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_targetstats (
    day date DEFAULT now() NOT NULL,
    clientid integer DEFAULT 0 NOT NULL,
    target integer DEFAULT 0 NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    modified smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1514 (class 1259 OID 939047)
-- Dependencies: 3
-- Name: ox_userlog_userlogid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_userlog_userlogid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2031 (class 0 OID 0)
-- Dependencies: 1514
-- Name: ox_userlog_userlogid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_userlog_userlogid_seq', 1, false);


--
-- TOC entry 1515 (class 1259 OID 939049)
-- Dependencies: 1799 1800 1801 1802 1803 3
-- Name: ox_userlog; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_userlog (
    userlogid integer DEFAULT nextval('ox_userlog_userlogid_seq'::regclass) NOT NULL,
    "timestamp" integer DEFAULT 0 NOT NULL,
    usertype smallint DEFAULT 0 NOT NULL,
    userid integer DEFAULT 0 NOT NULL,
    action integer DEFAULT 0 NOT NULL,
    object integer,
    details text
);


--
-- TOC entry 1523 (class 1259 OID 939151)
-- Dependencies: 3
-- Name: ox_zones_zoneid_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE ox_zones_zoneid_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2034 (class 0 OID 0)
-- Dependencies: 1523
-- Name: ox_zones_zoneid_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('ox_zones_zoneid_seq', 2, true);


--
-- TOC entry 1524 (class 1259 OID 939153)
-- Dependencies: 1843 1844 1845 1846 1847 1848 1849 1850 1851 1852 1853 1854 3
-- Name: ox_zones; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ox_zones (
    zoneid integer DEFAULT nextval('ox_zones_zoneid_seq'::regclass) NOT NULL,
    affiliateid integer,
    zonename character varying(255) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    delivery smallint DEFAULT 0 NOT NULL,
    zonetype smallint DEFAULT 0 NOT NULL,
    what text DEFAULT ''::text NOT NULL,
    width smallint DEFAULT 0 NOT NULL,
    height smallint DEFAULT 0 NOT NULL,
    chain text DEFAULT ''::text NOT NULL,
    prepend text DEFAULT ''::text NOT NULL,
    append text DEFAULT ''::text NOT NULL,
    appendtype smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 28 (class 1255 OID 939340)
-- Dependencies: 3
-- Name: date_format(timestamp with time zone, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION date_format(timestamp with time zone, text) RETURNS text
    AS 'SELECT CASE WHEN $1 = NULL THEN '''' ELSE to_char($1, $2) END'
    LANGUAGE sql;


--
-- TOC entry 23 (class 1255 OID 939335)
-- Dependencies: 3
-- Name: dayofmonth(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION dayofmonth(timestamp with time zone) RETURNS smallint
    AS 'SELECT date_part(''day'', $1)::int2'
    LANGUAGE sql;


--
-- TOC entry 21 (class 1255 OID 939333)
-- Dependencies: 3
-- Name: from_unixtime(integer); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION from_unixtime(integer) RETURNS timestamp without time zone
    AS 'SELECT (''epoch''::timestamp with time zone + ($1 || '' sec'')::interval)::timestamp'
    LANGUAGE sql;


--
-- TOC entry 27 (class 1255 OID 939339)
-- Dependencies: 3
-- Name: hour(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION hour(timestamp with time zone) RETURNS smallint
    AS 'SELECT date_part(''hour'', $1)::int2'
    LANGUAGE sql;


--
-- TOC entry 29 (class 1255 OID 939341)
-- Dependencies: 3
-- Name: if(boolean, character varying, character varying); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION if(boolean, character varying, character varying) RETURNS character varying
    AS 'SELECT CASE WHEN $1 THEN $2 ELSE $3 END'
    LANGUAGE sql;


--
-- TOC entry 24 (class 1255 OID 939336)
-- Dependencies: 3
-- Name: month(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION month(timestamp with time zone) RETURNS smallint
    AS 'SELECT date_part(''month'', $1)::int2'
    LANGUAGE sql;


--
-- TOC entry 22 (class 1255 OID 939334)
-- Dependencies: 3
-- Name: to_days(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION to_days(timestamp with time zone) RETURNS bigint
    AS 'SELECT CASE WHEN $1 = NULL THEN NULL ELSE floor(unix_timestamp($1)/86400)::int8 END'
    LANGUAGE sql;


--
-- TOC entry 20 (class 1255 OID 939332)
-- Dependencies: 3
-- Name: unix_timestamp(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION unix_timestamp(timestamp with time zone) RETURNS bigint
    AS 'SELECT (CASE WHEN $1 = NULL THEN 0 ELSE date_part(''epoch'', $1) END)::int8'
    LANGUAGE sql;


--
-- TOC entry 26 (class 1255 OID 939338)
-- Dependencies: 3
-- Name: week(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION week(timestamp with time zone) RETURNS smallint
    AS 'SELECT date_part(''week'', $1)::int2'
    LANGUAGE sql;


--
-- TOC entry 25 (class 1255 OID 939337)
-- Dependencies: 3
-- Name: year(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION year(timestamp with time zone) RETURNS integer
    AS 'SELECT date_part(''year'', $1)::int4'
    LANGUAGE sql;


--
-- TOC entry 2003 (class 0 OID 939204)
-- Dependencies: 1527
-- Data for Name: ox_acls; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2001 (class 0 OID 939180)
-- Dependencies: 1525
-- Data for Name: ox_adclicks; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2004 (class 0 OID 939222)
-- Dependencies: 1528
-- Data for Name: ox_adstats; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2002 (class 0 OID 939192)
-- Dependencies: 1526
-- Data for Name: ox_adviews; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 1999 (class 0 OID 939139)
-- Dependencies: 1522
-- Data for Name: ox_affiliates; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_affiliates (affiliateid, name, website, contact, email, username, password, permissions, language, publiczones) VALUES (1, 'Agency Publisher 1', 'http://fornax.net', 'Andrew Hill', 'andrew.hill@openads.org', 'publisher', '52aded165360352a0f5857571d96d68f', 31, '', false);


--
-- TOC entry 1998 (class 0 OID 939093)
-- Dependencies: 1520
-- Data for Name: ox_banners; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_banners (bannerid, clientid, active, priority, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, keyword, bannertext, description, autohtml, block, capping, compiledlimitation, append, appendtype, bannertype, transparent) VALUES (1, 2, true, 0, 'html', 0, 'html', '', '', 'Test HTML Banner!', 'Test HTML Banner!', 468, 60, 1, 0, '', '', '', '', '', '', 'Test HTML Banner!', true, 0, 0, 'true', '', 0, 0, false);
INSERT INTO ox_banners (bannerid, clientid, active, priority, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, keyword, bannertext, description, autohtml, block, capping, compiledlimitation, append, appendtype, bannertype, transparent) VALUES (2, 3, true, 1, 'html', 0, 'html', '', '', 'html test banner', '<a href=''{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;ismap='' target=''{target}''>html test banner</a>', 468, 60, 1, 0, '', 'https://developer.openx.org/', '', '', '', '', 'test banner', true, 0, 0, 'true', '', 0, 0, false);
INSERT INTO ox_banners (bannerid, clientid, active, priority, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, keyword, bannertext, description, autohtml, block, capping, compiledlimitation, append, appendtype, bannertype, transparent) VALUES (3, 4, true, 1, 'gif', 0, 'sql', '468x60.gif', '{url_prefix}/adimage.php?filename=468x60.gif&amp;contenttype=gif', '[targeturl]<a href=''{targeturl}'' target=''{target}''[status] onMouseOver="self.status=''{status}''; return true;" onMouseOut="self.status='''';return true;"[/status]>[/targeturl]<img src=''{imageurl}'' width=''{width}'' height=''{height}'' alt=''{alt}'' title=''{alt}'' border=''0''[nourl][status] onMouseOver="self.status=''{status}''; return true;" onMouseOut="self.status='''';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=''{targeturl}'' target=''{target}''[status] onMouseOver="self.status=''{status}''; return true;" onMouseOut="self.status='''';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]', '<a href=''{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest=https%3A%2F%2Fdeveloper.openx.org%2F'' target=''{target}''><img src=''{url_prefix}/adimage.php?filename=468x60.gif&amp;amp;contenttype=gif'' width=''468'' height=''60'' alt=''alt text'' title=''alt text'' border=''0''></a>', 468, 60, 1, 0, '', 'https://developer.openx.org/', 'alt text', '', '', '', 'sample gif banner', true, 0, 0, 'true', '', 0, 0, false);


--
-- TOC entry 1994 (class 0 OID 939038)
-- Dependencies: 1513
-- Data for Name: ox_cache; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 1996 (class 0 OID 939064)
-- Dependencies: 1517
-- Data for Name: ox_clients; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_clients (clientid, clientname, contact, email, views, clicks, clientusername, clientpassword, expire, activate, permissions, language, active, weight, target, parent, report, reportinterval, reportlastdate, reportdeactivate) VALUES (1, 'Advertiser 1', 'advertiser', 'example@example.com', NULL, NULL, 'advertiser', '02452e3484c42211b1c2884ad9b60c93', NULL, NULL, 25, '', NULL, 1, 0, NULL, true, 7, '2008-08-13', true);
INSERT INTO ox_clients (clientid, clientname, contact, email, views, clicks, clientusername, clientpassword, expire, activate, permissions, language, active, weight, target, parent, report, reportinterval, reportlastdate, reportdeactivate) VALUES (2, 'Advertiser 1 - Default Campaign', NULL, NULL, -1, -1, NULL, NULL, '2008-07-01', NULL, NULL, NULL, false, 1, 0, 1, NULL, 7, NULL, NULL);
INSERT INTO ox_clients (clientid, clientname, contact, email, views, clicks, clientusername, clientpassword, expire, activate, permissions, language, active, weight, target, parent, report, reportinterval, reportlastdate, reportdeactivate) VALUES (3, 'test campaign', NULL, NULL, -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, true, 1, 0, 1, NULL, 7, NULL, NULL);
INSERT INTO ox_clients (clientid, clientname, contact, email, views, clicks, clientusername, clientpassword, expire, activate, permissions, language, active, weight, target, parent, report, reportinterval, reportlastdate, reportdeactivate) VALUES (4, 'campaign 2 (gif)', NULL, NULL, -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, true, 1, 0, 1, NULL, 7, NULL, NULL);


--
-- TOC entry 2007 (class 0 OID 939257)
-- Dependencies: 1531
-- Data for Name: ox_config; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_config (configid, config_version, instance_id, my_header, my_footer, table_border_color, table_back_color, table_back_color_alternative, main_back_color, language, name, company_name, override_gd_imageformat, begin_of_week, percentage_decimals, type_sql_allow, type_url_allow, type_web_allow, type_html_allow, type_txt_allow, type_web_mode, type_web_url, type_web_dir, type_web_ftp, admin, admin_pw, admin_fullname, admin_email, admin_email_headers, admin_novice, default_banner_weight, default_campaign_weight, client_welcome, client_welcome_msg, content_gzip_compression, userlog_email, userlog_priority, userlog_autoclean, gui_show_campaign_info, gui_show_campaign_preview, gui_show_banner_info, gui_show_banner_preview, gui_show_banner_html, gui_show_matching, gui_show_parents, gui_hide_inactive, gui_link_compact_limit, qmail_patch, updates_enabled, updates_last_seen, updates_cache, updates_timestamp, updates_dev_builds, allow_invocation_plain, allow_invocation_js, allow_invocation_frame, allow_invocation_xmlrpc, allow_invocation_local, allow_invocation_interstitial, allow_invocation_popup, auto_clean_tables, auto_clean_tables_interval, auto_clean_userlog, auto_clean_userlog_interval, auto_clean_tables_vacuum, autotarget_factor, maintenance_timestamp, maintenance_cron_timestamp) VALUES (0, 200.314, 'a7b2360eb9584119dee0fb4ee56509021f7fa3f2', '', '', '#000099', '#CCCCCC', '#F7F7F7', '#FFFFFF', 'english', '', 'openx ltd.', '', 1, 2, true, true, false, true, true, 0, '', '', '', 'openx', '7a89a595cfc6cb85480202a143e37d2e', 'openx', 'test@open.org', '', true, 1, 1, true, '', false, true, true, true, true, false, true, true, false, true, false, false, 50, false, true, 0, 'b:0;', 1218620521, false, false, true, false, false, true, true, true, false, 5, false, 5, true, -1, 0, 0);


--
-- TOC entry 1997 (class 0 OID 939083)
-- Dependencies: 1518
-- Data for Name: ox_images; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_images (filename, contents, t_stamp) VALUES ('468x60.gif', 'GIF89a\\324\\001<\\000\\367\\000\\000\\000\\000\\000\\200\\000\\000\\000\\200\\000\\200\\200\\000\\000\\000\\200\\200\\000\\200\\000\\200\\200\\200\\200\\200\\300\\300\\300\\377\\000\\000\\000\\377\\000\\377\\377\\000\\000\\000\\377\\377\\000\\377\\000\\377\\377\\377\\377\\377\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\000\\0003\\000\\000f\\000\\000\\231\\000\\000\\314\\000\\000\\377\\0003\\000\\00033\\0003f\\0003\\231\\0003\\314\\0003\\377\\000f\\000\\000f3\\000ff\\000f\\231\\000f\\314\\000f\\377\\000\\231\\000\\000\\2313\\000\\231f\\000\\231\\231\\000\\231\\314\\000\\231\\377\\000\\314\\000\\000\\3143\\000\\314f\\000\\314\\231\\000\\314\\314\\000\\314\\377\\000\\377\\000\\000\\3773\\000\\377f\\000\\377\\231\\000\\377\\314\\000\\377\\3773\\000\\0003\\00033\\000f3\\000\\2313\\000\\3143\\000\\37733\\00033333f33\\23133\\31433\\3773f\\0003f33ff3f\\2313f\\3143f\\3773\\231\\0003\\23133\\231f3\\231\\2313\\231\\3143\\231\\3773\\314\\0003\\31433\\314f3\\314\\2313\\314\\3143\\314\\3773\\377\\0003\\37733\\377f3\\377\\2313\\377\\3143\\377\\377f\\000\\000f\\0003f\\000ff\\000\\231f\\000\\314f\\000\\377f3\\000f33f3ff3\\231f3\\314f3\\377ff\\000ff3fffff\\231ff\\314ff\\377f\\231\\000f\\2313f\\231ff\\231\\231f\\231\\314f\\231\\377f\\314\\000f\\3143f\\314ff\\314\\231f\\314\\314f\\314\\377f\\377\\000f\\3773f\\377ff\\377\\231f\\377\\314f\\377\\377\\231\\000\\000\\231\\0003\\231\\000f\\231\\000\\231\\231\\000\\314\\231\\000\\377\\2313\\000\\23133\\2313f\\2313\\231\\2313\\314\\2313\\377\\231f\\000\\231f3\\231ff\\231f\\231\\231f\\314\\231f\\377\\231\\231\\000\\231\\2313\\231\\231f\\231\\231\\231\\231\\231\\314\\231\\231\\377\\231\\314\\000\\231\\3143\\231\\314f\\231\\314\\231\\231\\314\\314\\231\\314\\377\\231\\377\\000\\231\\3773\\231\\377f\\231\\377\\231\\231\\377\\314\\231\\377\\377\\314\\000\\000\\314\\0003\\314\\000f\\314\\000\\231\\314\\000\\314\\314\\000\\377\\3143\\000\\31433\\3143f\\3143\\231\\3143\\314\\3143\\377\\314f\\000\\314f3\\314ff\\314f\\231\\314f\\314\\314f\\377\\314\\231\\000\\314\\2313\\314\\231f\\314\\231\\231\\314\\231\\314\\314\\231\\377\\314\\314\\000\\314\\3143\\314\\314f\\314\\314\\231\\314\\314\\314\\314\\314\\377\\314\\377\\000\\314\\3773\\314\\377f\\314\\377\\231\\314\\377\\314\\314\\377\\377\\377\\000\\000\\377\\0003\\377\\000f\\377\\000\\231\\377\\000\\314\\377\\000\\377\\3773\\000\\37733\\3773f\\3773\\231\\3773\\314\\3773\\377\\377f\\000\\377f3\\377ff\\377f\\231\\377f\\314\\377f\\377\\377\\231\\000\\377\\2313\\377\\231f\\377\\231\\231\\377\\231\\314\\377\\231\\377\\377\\314\\000\\377\\3143\\377\\314f\\377\\314\\231\\377\\314\\314\\377\\314\\377\\377\\377\\000\\377\\3773\\377\\377f\\377\\377\\231\\377\\377\\314\\377\\377\\377!\\371\\004\\001\\000\\000\\020\\000,\\000\\000\\000\\000\\324\\001<\\000\\000\\010\\377\\000\\177\\344\\020Hp\\240\\301\\202\\010\\017*L\\310p\\241\\303\\206\\020\\037J\\214Hq\\242\\305\\212\\030/j\\314\\310q\\243\\307\\216 ?\\212\\014Ir\\244\\311\\222(O\\252L\\270\\262e\\312\\227.c\\302\\234)\\263&\\315\\2336s\\342\\334\\251S''\\317\\237=\\201\\012\\015Jt\\250\\321\\242H\\217*E\\232\\264\\351\\322\\247N\\243B\\235*\\265*U\\245W\\255j\\315\\312u\\253\\327\\256`\\277\\266\\024\\033\\266,\\331\\263f\\323\\242];S\\255[\\266p\\337\\312\\215K\\027j\\335\\273s\\363\\342\\335\\253\\267\\357C\\277\\200\\371\\012\\016LxpT\\303\\205\\023#^\\254\\270\\361F\\307\\220\\031K\\216L\\371\\356\\344\\313\\2253c\\336\\314U\\263g\\316\\240?\\213V\\031\\272\\364\\350\\323\\246SCD\\315Z\\265\\353\\326\\216_\\313\\206=\\273v_\\332\\270m\\353\\316\\235u\\267o\\336\\277\\203\\377\\004N\\\\\\270\\361\\342%\\217+G\\276\\2749A\\346\\320\\235K/>\\275z\\364\\353\\263\\261k\\267\\316]s\\367\\357\\333\\3033\\272\\026O\\036\\274y\\275\\347\\323\\227_\\217\\226\\275{\\365\\360\\251\\306\\237\\377\\276~Q\\373\\370\\351\\353\\247\\271\\277\\177\\376\\377#\\001(\\240\\177\\004FT\\340\\201\\003&8\\220\\202\\014"\\330\\237\\203\\015F\\030\\237\\204\\024Bh\\236\\205\\025fh\\235\\206\\034b\\330\\234\\207\\035\\206(\\234\\210$\\202\\250\\233\\211%\\246\\370\\232\\212,\\242X\\232\\213-\\306\\210\\231\\2144\\302\\270\\230\\2155\\346\\310\\227\\216<\\342H\\227\\217=\\006\\331\\036\\220D\\012\\371V\\221H\\0329\\244\\222L&\\311T\\223P:9\\234\\224TFyT\\225XZ\\031\\224\\226\\\\fi\\222\\227]\\206\\371\\030\\230d\\212\\031R\\231h\\2329\\246\\232l\\242\\231\\346\\233m2\\024''\\234t\\012T\\347\\235l\\006\\004\\000;', '2008-08-13 11:59:07+02');


--
-- TOC entry 2005 (class 0 OID 939236)
-- Dependencies: 1529
-- Data for Name: ox_session; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_session (sessionid, sessiondata, lastused) VALUES ('1aeee8fb6bbcc34c59a9be6f23e0cd60', 'a:5:{s:8:"usertype";i:1;s:8:"loggedin";s:1:"t";s:8:"username";s:5:"openx";s:15:"maint_update_js";b:1;s:5:"prefs";a:4:{s:16:"client-index.php";a:4:{s:12:"hideinactive";b:0;s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";s:7:"1,2,4,3";}s:17:"campaign-zone.php";a:2:{s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";}s:19:"affiliate-index.php";a:3:{s:9:"listorder";s:0:"";s:14:"orderdirection";s:0:"";s:5:"nodes";s:1:"1";}s:16:"zone-include.php";a:3:{s:12:"hideinactive";b:0;s:11:"showbanners";b:1;s:13:"showcampaigns";b:0;}}}', '2008-08-13 12:01:47+02');


--
-- TOC entry 2006 (class 0 OID 939247)
-- Dependencies: 1530
-- Data for Name: ox_targetstats; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 1995 (class 0 OID 939049)
-- Dependencies: 1515
-- Data for Name: ox_userlog; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2000 (class 0 OID 939153)
-- Dependencies: 1524
-- Data for Name: ox_zones; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ox_zones (zoneid, affiliateid, zonename, description, delivery, zonetype, what, width, height, chain, prepend, append, appendtype) VALUES (1, 1, 'Publisher 1 - Default', '', 0, 3, 'clientid:2,clientid:3', 468, 60, '', '', '', 0);
INSERT INTO ox_zones (zoneid, affiliateid, zonename, description, delivery, zonetype, what, width, height, chain, prepend, append, appendtype) VALUES (2, 1, 'Agency Publisher 1 - Default', '', 0, 3, 'clientid:2,clientid:4', 468, 60, '', '', '', 0);


--
-- TOC entry 1982 (class 2606 OID 939233)
-- Dependencies: 1528 1528 1528 1528 1528 1528
-- Name: ox_adstats_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_adstats
    ADD CONSTRAINT ox_adstats_pkey PRIMARY KEY (day, hour, bannerid, zoneid, source);


--
-- TOC entry 1967 (class 2606 OID 939150)
-- Dependencies: 1522 1522
-- Name: ox_affiliates_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_affiliates
    ADD CONSTRAINT ox_affiliates_pkey PRIMARY KEY (affiliateid);


--
-- TOC entry 1965 (class 2606 OID 939130)
-- Dependencies: 1520 1520
-- Name: ox_banners_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_banners
    ADD CONSTRAINT ox_banners_pkey PRIMARY KEY (bannerid);


--
-- TOC entry 1955 (class 2606 OID 939046)
-- Dependencies: 1513 1513
-- Name: ox_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_cache
    ADD CONSTRAINT ox_cache_pkey PRIMARY KEY (cacheid);


--
-- TOC entry 1960 (class 2606 OID 939076)
-- Dependencies: 1517 1517
-- Name: ox_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_clients
    ADD CONSTRAINT ox_clients_pkey PRIMARY KEY (clientid);


--
-- TOC entry 1989 (class 2606 OID 939331)
-- Dependencies: 1531 1531
-- Name: ox_config_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_config
    ADD CONSTRAINT ox_config_pkey PRIMARY KEY (configid);


--
-- TOC entry 1962 (class 2606 OID 939090)
-- Dependencies: 1518 1518
-- Name: ox_images_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_images
    ADD CONSTRAINT ox_images_pkey PRIMARY KEY (filename);


--
-- TOC entry 1985 (class 2606 OID 939246)
-- Dependencies: 1529 1529
-- Name: ox_session_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_session
    ADD CONSTRAINT ox_session_pkey PRIMARY KEY (sessionid);


--
-- TOC entry 1987 (class 2606 OID 939256)
-- Dependencies: 1530 1530 1530
-- Name: ox_targetstats_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_targetstats
    ADD CONSTRAINT ox_targetstats_pkey PRIMARY KEY (day, clientid);


--
-- TOC entry 1957 (class 2606 OID 939061)
-- Dependencies: 1515 1515
-- Name: ox_userlog_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_userlog
    ADD CONSTRAINT ox_userlog_pkey PRIMARY KEY (userlogid);


--
-- TOC entry 1970 (class 2606 OID 939172)
-- Dependencies: 1524 1524
-- Name: ox_zones_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ox_zones
    ADD CONSTRAINT ox_zones_pkey PRIMARY KEY (zoneid);


--
-- TOC entry 1978 (class 1259 OID 939221)
-- Dependencies: 1527 1527
-- Name: ox_acls_bannerid_executionorder; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX ox_acls_bannerid_executionorder ON ox_acls USING btree (bannerid, executionorder);


--
-- TOC entry 1979 (class 1259 OID 939220)
-- Dependencies: 1527
-- Name: ox_acls_bannerid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_acls_bannerid_idx ON ox_acls USING btree (bannerid);


--
-- TOC entry 1972 (class 1259 OID 939189)
-- Dependencies: 1525 1525
-- Name: ox_adclicks_bid_date_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adclicks_bid_date_idx ON ox_adclicks USING btree (bannerid, t_stamp);


--
-- TOC entry 1973 (class 1259 OID 939190)
-- Dependencies: 1525
-- Name: ox_adclicks_date_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adclicks_date_idx ON ox_adclicks USING btree (t_stamp);


--
-- TOC entry 1974 (class 1259 OID 939191)
-- Dependencies: 1525
-- Name: ox_adclicks_zoneid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adclicks_zoneid_idx ON ox_adclicks USING btree (zoneid);


--
-- TOC entry 1980 (class 1259 OID 939234)
-- Dependencies: 1528 1528
-- Name: ox_adstats_bid_day_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adstats_bid_day_idx ON ox_adstats USING btree (bannerid, day);


--
-- TOC entry 1983 (class 1259 OID 939235)
-- Dependencies: 1528
-- Name: ox_adstats_zoneid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adstats_zoneid_idx ON ox_adstats USING btree (zoneid);


--
-- TOC entry 1975 (class 1259 OID 939201)
-- Dependencies: 1526 1526
-- Name: ox_adviews_bid_date_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adviews_bid_date_idx ON ox_adviews USING btree (bannerid, t_stamp);


--
-- TOC entry 1976 (class 1259 OID 939202)
-- Dependencies: 1526
-- Name: ox_adviews_date_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adviews_date_idx ON ox_adviews USING btree (t_stamp);


--
-- TOC entry 1977 (class 1259 OID 939203)
-- Dependencies: 1526
-- Name: ox_adviews_zoneid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_adviews_zoneid_idx ON ox_adviews USING btree (zoneid);


--
-- TOC entry 1963 (class 1259 OID 939136)
-- Dependencies: 1520
-- Name: ox_banners_clientid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_banners_clientid_idx ON ox_banners USING btree (clientid);


--
-- TOC entry 1958 (class 1259 OID 939082)
-- Dependencies: 1517
-- Name: ox_clients_parent_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_clients_parent_idx ON ox_clients USING btree (parent);


--
-- TOC entry 1968 (class 1259 OID 939178)
-- Dependencies: 1524
-- Name: ox_zones_affiliateid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_zones_affiliateid_idx ON ox_zones USING btree (affiliateid);


--
-- TOC entry 1971 (class 1259 OID 939179)
-- Dependencies: 1524 1524
-- Name: ox_zones_zonename_zoneid_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ox_zones_zonename_zoneid_idx ON ox_zones USING btree (zonename, zoneid);


--
-- TOC entry 1993 (class 2606 OID 939215)
-- Dependencies: 1527 1964 1520
-- Name: ox_acls_bannerid_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY ox_acls
    ADD CONSTRAINT ox_acls_bannerid_fk FOREIGN KEY (bannerid) REFERENCES ox_banners(bannerid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1991 (class 2606 OID 939131)
-- Dependencies: 1517 1520 1959
-- Name: ox_banners_clientid_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY ox_banners
    ADD CONSTRAINT ox_banners_clientid_fk FOREIGN KEY (clientid) REFERENCES ox_clients(clientid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1990 (class 2606 OID 939077)
-- Dependencies: 1517 1517 1959
-- Name: ox_clients_parent_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY ox_clients
    ADD CONSTRAINT ox_clients_parent_fk FOREIGN KEY (parent) REFERENCES ox_clients(clientid) ON UPDATE CASCADE ON DELETE CASCADE DEFERRABLE;


--
-- TOC entry 1992 (class 2606 OID 939173)
-- Dependencies: 1966 1522 1524
-- Name: ox_zones_affiliateid_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY ox_zones
    ADD CONSTRAINT ox_zones_affiliateid_fk FOREIGN KEY (affiliateid) REFERENCES ox_affiliates(affiliateid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2012 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- TOC entry 2013 (class 0 OID 0)
-- Dependencies: 1527
-- Name: ox_acls; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_acls FROM PUBLIC;
REVOKE ALL ON TABLE ox_acls FROM openx;
GRANT ALL ON TABLE ox_acls TO openx;


--
-- TOC entry 2014 (class 0 OID 0)
-- Dependencies: 1525
-- Name: ox_adclicks; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_adclicks FROM PUBLIC;
REVOKE ALL ON TABLE ox_adclicks FROM openx;
GRANT ALL ON TABLE ox_adclicks TO openx;


--
-- TOC entry 2015 (class 0 OID 0)
-- Dependencies: 1528
-- Name: ox_adstats; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_adstats FROM PUBLIC;
REVOKE ALL ON TABLE ox_adstats FROM openx;
GRANT ALL ON TABLE ox_adstats TO openx;


--
-- TOC entry 2016 (class 0 OID 0)
-- Dependencies: 1526
-- Name: ox_adviews; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_adviews FROM PUBLIC;
REVOKE ALL ON TABLE ox_adviews FROM openx;
GRANT ALL ON TABLE ox_adviews TO openx;


--
-- TOC entry 2018 (class 0 OID 0)
-- Dependencies: 1521
-- Name: ox_affiliates_affiliateid_seq; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON SEQUENCE ox_affiliates_affiliateid_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ox_affiliates_affiliateid_seq FROM openx;
GRANT ALL ON SEQUENCE ox_affiliates_affiliateid_seq TO openx;


--
-- TOC entry 2019 (class 0 OID 0)
-- Dependencies: 1522
-- Name: ox_affiliates; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_affiliates FROM PUBLIC;
REVOKE ALL ON TABLE ox_affiliates FROM openx;
GRANT ALL ON TABLE ox_affiliates TO openx;


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 1519
-- Name: ox_banners_bannerid_seq; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON SEQUENCE ox_banners_bannerid_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ox_banners_bannerid_seq FROM openx;
GRANT ALL ON SEQUENCE ox_banners_bannerid_seq TO openx;


--
-- TOC entry 2022 (class 0 OID 0)
-- Dependencies: 1520
-- Name: ox_banners; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_banners FROM PUBLIC;
REVOKE ALL ON TABLE ox_banners FROM openx;
GRANT ALL ON TABLE ox_banners TO openx;


--
-- TOC entry 2023 (class 0 OID 0)
-- Dependencies: 1513
-- Name: ox_cache; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_cache FROM PUBLIC;
REVOKE ALL ON TABLE ox_cache FROM openx;
GRANT ALL ON TABLE ox_cache TO openx;


--
-- TOC entry 2025 (class 0 OID 0)
-- Dependencies: 1516
-- Name: ox_clients_clientid_seq; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON SEQUENCE ox_clients_clientid_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ox_clients_clientid_seq FROM openx;
GRANT ALL ON SEQUENCE ox_clients_clientid_seq TO openx;


--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 1517
-- Name: ox_clients; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_clients FROM PUBLIC;
REVOKE ALL ON TABLE ox_clients FROM openx;
GRANT ALL ON TABLE ox_clients TO openx;


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 1531
-- Name: ox_config; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_config FROM PUBLIC;
REVOKE ALL ON TABLE ox_config FROM openx;
GRANT ALL ON TABLE ox_config TO openx;


--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 1518
-- Name: ox_images; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_images FROM PUBLIC;
REVOKE ALL ON TABLE ox_images FROM openx;
GRANT ALL ON TABLE ox_images TO openx;


--
-- TOC entry 2029 (class 0 OID 0)
-- Dependencies: 1529
-- Name: ox_session; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_session FROM PUBLIC;
REVOKE ALL ON TABLE ox_session FROM openx;
GRANT ALL ON TABLE ox_session TO openx;


--
-- TOC entry 2030 (class 0 OID 0)
-- Dependencies: 1530
-- Name: ox_targetstats; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_targetstats FROM PUBLIC;
REVOKE ALL ON TABLE ox_targetstats FROM openx;
GRANT ALL ON TABLE ox_targetstats TO openx;


--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 1514
-- Name: ox_userlog_userlogid_seq; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON SEQUENCE ox_userlog_userlogid_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ox_userlog_userlogid_seq FROM openx;
GRANT ALL ON SEQUENCE ox_userlog_userlogid_seq TO openx;


--
-- TOC entry 2033 (class 0 OID 0)
-- Dependencies: 1515
-- Name: ox_userlog; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_userlog FROM PUBLIC;
REVOKE ALL ON TABLE ox_userlog FROM openx;
GRANT ALL ON TABLE ox_userlog TO openx;


--
-- TOC entry 2035 (class 0 OID 0)
-- Dependencies: 1523
-- Name: ox_zones_zoneid_seq; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON SEQUENCE ox_zones_zoneid_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ox_zones_zoneid_seq FROM openx;
GRANT ALL ON SEQUENCE ox_zones_zoneid_seq TO openx;


--
-- TOC entry 2036 (class 0 OID 0)
-- Dependencies: 1524
-- Name: ox_zones; Type: ACL; Schema: public; Owner: -
--

REVOKE ALL ON TABLE ox_zones FROM PUBLIC;
REVOKE ALL ON TABLE ox_zones FROM openx;
GRANT ALL ON TABLE ox_zones TO openx;


-- Completed on 2008-08-13 12:02:10 CEST

--
-- PostgreSQL database dump complete
--

