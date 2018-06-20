--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.13
-- Dumped by pg_dump version 10.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: mailer; Type: SCHEMA; Schema: -; Owner: g_root
--

CREATE SCHEMA mailer;


ALTER SCHEMA mailer OWNER TO g_root;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: log_ask; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_ask (
    id integer NOT NULL,
    ip character varying(50),
    cmd character varying(50),
    query text,
    request text,
    result text,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.log_ask OWNER TO postgres;

--
-- Name: log_ask_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_ask_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_ask_id_seq OWNER TO postgres;

--
-- Name: log_ask_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_ask_id_seq OWNED BY public.log_ask.id;


--
-- Name: migration_drop; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migration_drop (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration_drop OWNER TO postgres;

--
-- Name: tbl_account; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_account (
    id integer NOT NULL,
    from_name character varying(100),
    from_email character varying(100),
    smtp_host character varying(100),
    smtp_port character varying(100),
    smtp_username character varying(100),
    smtp_password character varying(100),
    imap_username character varying(255),
    imap_password character varying(255),
    imap_host character varying(255),
    imap_port character varying(255),
    imap_encryption character varying(10),
    smtp_encryption character varying(10),
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status integer DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_account OWNER TO postgres;

--
-- Name: tbl_account_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_account_id_seq OWNER TO postgres;

--
-- Name: tbl_account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_account_id_seq OWNED BY public.tbl_account.id;


--
-- Name: tbl_base; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_base (
    id integer NOT NULL,
    name character varying(255),
    lang_id integer,
    group_id integer,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status smallint DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_base OWNER TO postgres;

--
-- Name: tbl_base_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_base_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_base_id_seq OWNER TO postgres;

--
-- Name: tbl_base_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_base_id_seq OWNED BY public.tbl_base.id;


--
-- Name: tbl_black_list; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_black_list (
    id integer NOT NULL,
    email character varying(255),
    type text,
    message text,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer
);


ALTER TABLE public.tbl_black_list OWNER TO postgres;

--
-- Name: tbl_black_list_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_black_list_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_black_list_id_seq OWNER TO postgres;

--
-- Name: tbl_black_list_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_black_list_id_seq OWNED BY public.tbl_black_list.id;


--
-- Name: tbl_city_drop; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_city_drop (
    id integer NOT NULL,
    name character varying(255),
    country_id integer,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status smallint DEFAULT 1
);


ALTER TABLE public.tbl_city_drop OWNER TO postgres;

--
-- Name: tbl_city_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_city_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_city_id_seq OWNER TO postgres;

--
-- Name: tbl_city_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_city_id_seq OWNED BY public.tbl_city_drop.id;


--
-- Name: tbl_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_clients (
    id integer NOT NULL,
    email character varying(100),
    country_id integer,
    city_id integer,
    other text,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status smallint DEFAULT 1
);


ALTER TABLE public.tbl_clients OWNER TO postgres;

--
-- Name: tbl_clients_base; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_clients_base (
    id integer NOT NULL,
    status smallint DEFAULT 1,
    client_id integer,
    base_id integer,
    file_id integer
);


ALTER TABLE public.tbl_clients_base OWNER TO postgres;

--
-- Name: tbl_clients_base_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_clients_base_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_clients_base_id_seq OWNER TO postgres;

--
-- Name: tbl_clients_base_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_clients_base_id_seq OWNED BY public.tbl_clients_base.id;


--
-- Name: tbl_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_clients_id_seq OWNER TO postgres;

--
-- Name: tbl_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_clients_id_seq OWNED BY public.tbl_clients.id;


--
-- Name: tbl_clients_param; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_clients_param (
    id integer NOT NULL,
    alias character varying(255),
    name character varying(255),
    type_id character varying(10),
    show integer DEFAULT 1,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status integer DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_clients_param OWNER TO postgres;

--
-- Name: tbl_clients_param_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_clients_param_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_clients_param_id_seq OWNER TO postgres;

--
-- Name: tbl_clients_param_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_clients_param_id_seq OWNED BY public.tbl_clients_param.id;


--
-- Name: tbl_country_drop; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_country_drop (
    id integer NOT NULL,
    name character varying(255),
    iso character varying(10),
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status integer DEFAULT 1
);


ALTER TABLE public.tbl_country_drop OWNER TO postgres;

--
-- Name: tbl_country_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_country_id_seq OWNER TO postgres;

--
-- Name: tbl_country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_country_id_seq OWNED BY public.tbl_country_drop.id;


--
-- Name: tbl_files; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_files (
    id integer NOT NULL,
    name character varying(255),
    file character varying(255),
    date_upload integer,
    "iBook" smallint,
    "iHeader" smallint,
    base_id integer,
    "column" text,
    state smallint DEFAULT 1,
    result text,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status smallint DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_files OWNER TO postgres;

--
-- Name: tbl_files_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_files_id_seq OWNER TO postgres;

--
-- Name: tbl_files_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_files_id_seq OWNED BY public.tbl_files.id;


--
-- Name: tbl_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_group (
    id integer NOT NULL,
    name character varying(255),
    site character varying(255),
    account_id integer,
    domain character varying(255),
    color_class character varying(50),
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status integer DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_group OWNER TO postgres;

--
-- Name: tbl_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_group_id_seq OWNER TO postgres;

--
-- Name: tbl_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_group_id_seq OWNED BY public.tbl_group.id;


--
-- Name: tbl_lang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_lang (
    id integer NOT NULL,
    name character varying(255),
    main smallint DEFAULT 1,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status integer DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_lang OWNER TO postgres;

--
-- Name: tbl_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_lang_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_lang_id_seq OWNER TO postgres;

--
-- Name: tbl_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_lang_id_seq OWNED BY public.tbl_lang.id;


--
-- Name: tbl_letter_file; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_letter_file (
    id integer NOT NULL,
    status integer DEFAULT 1,
    name character varying(255),
    file character varying(255)
);


ALTER TABLE public.tbl_letter_file OWNER TO postgres;

--
-- Name: tbl_letter_file_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_letter_file_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_letter_file_id_seq OWNER TO postgres;

--
-- Name: tbl_letter_file_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_letter_file_id_seq OWNED BY public.tbl_letter_file.id;


--
-- Name: tbl_mailer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_mailer (
    id integer NOT NULL,
    group_id integer,
    base_ids text,
    account_id integer,
    lang_id integer,
    name character varying(255),
    body text,
    temp_id character varying(100),
    files text,
    template_id integer,
    date_start integer,
    max integer,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status integer DEFAULT 1,
    error_message text
);


ALTER TABLE public.tbl_mailer OWNER TO postgres;

--
-- Name: tbl_mailer_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_mailer_data (
    id integer NOT NULL,
    client_id integer,
    client_email character varying(255),
    base_id integer,
    mailer_id integer,
    lang_id integer,
    send integer,
    deliver integer,
    open integer,
    spam integer,
    link text,
    error text,
    hash character varying(100),
    info text,
    server text,
    message_id character varying(255),
    created_at integer,
    updated_at integer,
    status smallint DEFAULT 1
);


ALTER TABLE public.tbl_mailer_data OWNER TO postgres;

--
-- Name: tbl_mailer_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_mailer_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_mailer_data_id_seq OWNER TO postgres;

--
-- Name: tbl_mailer_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_mailer_data_id_seq OWNED BY public.tbl_mailer_data.id;


--
-- Name: tbl_mailer_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_mailer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_mailer_id_seq OWNER TO postgres;

--
-- Name: tbl_mailer_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_mailer_id_seq OWNED BY public.tbl_mailer.id;


--
-- Name: tbl_migration_drop; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_migration_drop (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.tbl_migration_drop OWNER TO postgres;

--
-- Name: tbl_pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pages (
    id integer NOT NULL,
    name character varying(255),
    lang_id integer,
    alias character varying(50),
    link character varying(255),
    temp_id integer,
    body text,
    style text,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    sort integer,
    status integer DEFAULT 1
);


ALTER TABLE public.tbl_pages OWNER TO postgres;

--
-- Name: tbl_pages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pages_id_seq OWNER TO postgres;

--
-- Name: tbl_pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pages_id_seq OWNED BY public.tbl_pages.id;


--
-- Name: tbl_profile; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_profile (
    id integer NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    full_name character varying(255),
    timezone character varying(255)
);


ALTER TABLE public.tbl_profile OWNER TO postgres;

--
-- Name: tbl_profile_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_profile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_profile_id_seq OWNER TO postgres;

--
-- Name: tbl_profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_profile_id_seq OWNED BY public.tbl_profile.id;


--
-- Name: tbl_role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_role (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    can_admin smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.tbl_role OWNER TO postgres;

--
-- Name: tbl_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_role_id_seq OWNER TO postgres;

--
-- Name: tbl_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_role_id_seq OWNED BY public.tbl_role.id;


--
-- Name: tbl_templates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_templates (
    id integer NOT NULL,
    group_id integer,
    name character varying(255),
    body text,
    temp_id character varying(50),
    lang_id integer,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    status integer DEFAULT 1,
    del smallint DEFAULT 0
);


ALTER TABLE public.tbl_templates OWNER TO postgres;

--
-- Name: tbl_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_templates_id_seq OWNER TO postgres;

--
-- Name: tbl_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_templates_id_seq OWNED BY public.tbl_templates.id;


--
-- Name: tbl_tmp_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_tmp_link (
    id integer NOT NULL,
    mailer_data_id integer,
    link text,
    hash character varying(255),
    count smallint,
    created_at integer
);


ALTER TABLE public.tbl_tmp_link OWNER TO postgres;

--
-- Name: tbl_tmp_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_tmp_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_tmp_link_id_seq OWNER TO postgres;

--
-- Name: tbl_tmp_link_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_tmp_link_id_seq OWNED BY public.tbl_tmp_link.id;


--
-- Name: tbl_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user (
    id integer NOT NULL,
    role_id integer NOT NULL,
    status smallint NOT NULL,
    email character varying(255),
    username character varying(255),
    password character varying(255),
    auth_key character varying(255),
    access_token character varying(255),
    logged_in_ip character varying(255),
    logged_in_at timestamp(0) without time zone,
    created_ip character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    banned_at timestamp(0) without time zone,
    banned_reason character varying(255)
);


ALTER TABLE public.tbl_user OWNER TO postgres;

--
-- Name: tbl_user_auth; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user_auth (
    id integer NOT NULL,
    user_id integer NOT NULL,
    provider character varying(255) NOT NULL,
    provider_id character varying(255) NOT NULL,
    provider_attributes text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_user_auth OWNER TO postgres;

--
-- Name: tbl_user_auth_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_auth_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_auth_id_seq OWNER TO postgres;

--
-- Name: tbl_user_auth_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_auth_id_seq OWNED BY public.tbl_user_auth.id;


--
-- Name: tbl_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_id_seq OWNER TO postgres;

--
-- Name: tbl_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_id_seq OWNED BY public.tbl_user.id;


--
-- Name: tbl_user_token; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user_token (
    id integer NOT NULL,
    user_id integer,
    type smallint NOT NULL,
    token character varying(255) NOT NULL,
    data character varying(255),
    created_at timestamp(0) without time zone,
    expired_at timestamp(0) without time zone
);


ALTER TABLE public.tbl_user_token OWNER TO postgres;

--
-- Name: tbl_user_token_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_token_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_token_id_seq OWNER TO postgres;

--
-- Name: tbl_user_token_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_token_id_seq OWNED BY public.tbl_user_token.id;


--
-- Name: log_ask id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_ask ALTER COLUMN id SET DEFAULT nextval('public.log_ask_id_seq'::regclass);


--
-- Name: tbl_account id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_account ALTER COLUMN id SET DEFAULT nextval('public.tbl_account_id_seq'::regclass);


--
-- Name: tbl_base id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_base ALTER COLUMN id SET DEFAULT nextval('public.tbl_base_id_seq'::regclass);


--
-- Name: tbl_black_list id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_black_list ALTER COLUMN id SET DEFAULT nextval('public.tbl_black_list_id_seq'::regclass);


--
-- Name: tbl_city_drop id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_city_drop ALTER COLUMN id SET DEFAULT nextval('public.tbl_city_id_seq'::regclass);


--
-- Name: tbl_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients ALTER COLUMN id SET DEFAULT nextval('public.tbl_clients_id_seq'::regclass);


--
-- Name: tbl_clients_base id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients_base ALTER COLUMN id SET DEFAULT nextval('public.tbl_clients_base_id_seq'::regclass);


--
-- Name: tbl_clients_param id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients_param ALTER COLUMN id SET DEFAULT nextval('public.tbl_clients_param_id_seq'::regclass);


--
-- Name: tbl_country_drop id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_country_drop ALTER COLUMN id SET DEFAULT nextval('public.tbl_country_id_seq'::regclass);


--
-- Name: tbl_files id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_files ALTER COLUMN id SET DEFAULT nextval('public.tbl_files_id_seq'::regclass);


--
-- Name: tbl_group id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_group ALTER COLUMN id SET DEFAULT nextval('public.tbl_group_id_seq'::regclass);


--
-- Name: tbl_lang id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_lang ALTER COLUMN id SET DEFAULT nextval('public.tbl_lang_id_seq'::regclass);


--
-- Name: tbl_letter_file id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_letter_file ALTER COLUMN id SET DEFAULT nextval('public.tbl_letter_file_id_seq'::regclass);


--
-- Name: tbl_mailer id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_mailer ALTER COLUMN id SET DEFAULT nextval('public.tbl_mailer_id_seq'::regclass);


--
-- Name: tbl_mailer_data id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_mailer_data ALTER COLUMN id SET DEFAULT nextval('public.tbl_mailer_data_id_seq'::regclass);


--
-- Name: tbl_pages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pages ALTER COLUMN id SET DEFAULT nextval('public.tbl_pages_id_seq'::regclass);


--
-- Name: tbl_profile id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_profile ALTER COLUMN id SET DEFAULT nextval('public.tbl_profile_id_seq'::regclass);


--
-- Name: tbl_role id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_role ALTER COLUMN id SET DEFAULT nextval('public.tbl_role_id_seq'::regclass);


--
-- Name: tbl_templates id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_templates ALTER COLUMN id SET DEFAULT nextval('public.tbl_templates_id_seq'::regclass);


--
-- Name: tbl_tmp_link id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_tmp_link ALTER COLUMN id SET DEFAULT nextval('public.tbl_tmp_link_id_seq'::regclass);


--
-- Name: tbl_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user ALTER COLUMN id SET DEFAULT nextval('public.tbl_user_id_seq'::regclass);


--
-- Name: tbl_user_auth id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_auth ALTER COLUMN id SET DEFAULT nextval('public.tbl_user_auth_id_seq'::regclass);


--
-- Name: tbl_user_token id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_token ALTER COLUMN id SET DEFAULT nextval('public.tbl_user_token_id_seq'::regclass);


--
-- Data for Name: log_ask; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: migration_drop; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.migration_drop VALUES ('m000000_000000_base', 1485426476);


--
-- Data for Name: tbl_account; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_account VALUES (2, 'sadfasdf', 'nikalas11@ya.ru', '', '', '', '', '', '', '', '', '', '', 1529388148, 1529388148, 1, 1, 2, 1, 1);
INSERT INTO public.tbl_account VALUES (1, 'Test', 'nikalas10@ya.ru', 'smtp.yandex.ua', '465', 'nikalas10@ya.ru', 'Hgnk2310', 'nikalas10@ya.ru', 'Hgnk23101', 'imap.yandex.ru', '993', 'ssl', 'ssl', 1485438626, 1529405811, 1, NULL, 1, -1, 0);


--
-- Data for Name: tbl_base; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_base VALUES (1, 'Test', NULL, 3, 1485436959, 1485436959, 1, 1, 1, 1, 1);
INSERT INTO public.tbl_base VALUES (3, 'xgsdfgdf 3 4', 1, 6, 1529385849, 1529388055, 1, 1, 2, 1, 1);
INSERT INTO public.tbl_base VALUES (2, 'No Active 2', 1, 3, 1485436972, 1529388044, 1, 1, 3, 1, 1);
INSERT INTO public.tbl_base VALUES (4, 'Test base', 1, 3, 1529402719, 1529402719, 1, 1, 1, 1, 0);


--
-- Data for Name: tbl_black_list; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_city_drop; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_clients VALUES (2, 'nikalas9@ya.ru', NULL, NULL, '{"first":""}', 1485438340, 1529402794, 1, 1, 1);
INSERT INTO public.tbl_clients VALUES (4, 'nikalas98542@ya.ru', NULL, NULL, '{"first":""}', 1529402810, 1529402810, 1, 1, 1);
INSERT INTO public.tbl_clients VALUES (5, 'nikalas9@gmail.com', NULL, NULL, '{"first":""}', 1529402840, 1529402840, 1, 1, 1);


--
-- Data for Name: tbl_clients_base; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_clients_base VALUES (5, 0, 2, 4, NULL);
INSERT INTO public.tbl_clients_base VALUES (6, 0, 4, 4, NULL);
INSERT INTO public.tbl_clients_base VALUES (7, 0, 5, 4, NULL);


--
-- Data for Name: tbl_clients_param; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_clients_param VALUES (1, 'first', 'first', 'text', 1, 1485437562, 1485437562, 1, 1, 1, 1, 0);
INSERT INTO public.tbl_clients_param VALUES (2, 'two', 'two', 'text', 1, 1529327003, 1529327003, 1, 1, 2, 1, 1);


--
-- Data for Name: tbl_country_drop; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_files; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_files VALUES (1, 'email.xls', 'X7sK3ZXaMZank6hXo3TeOf8u9W2FZ9KC.xls', NULL, NULL, NULL, 1, '{"A":"email","B":"first"}', 1, '{"total":3,"created":2,"updated":0,"dub":0}', 1485438320, 1485438340, 1, 1, 1, 0);


--
-- Data for Name: tbl_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_group VALUES (5, 'My One group', 'dfgsdfg', NULL, NULL, 'bg-color-pinkDark', 1529326900, 1529326933, 1, 1, 2, 1, 1);
INSERT INTO public.tbl_group VALUES (9, 'test', '', NULL, NULL, NULL, 1529387439, 1529387439, 1, 1, 5, 1, 1);
INSERT INTO public.tbl_group VALUES (8, 'dsfgsdfg', '', NULL, NULL, NULL, 1529387363, 1529387363, 1, 1, 5, 1, 1);
INSERT INTO public.tbl_group VALUES (7, 'asdfasdf 2 fdgsdf g', '', NULL, NULL, NULL, 1529387266, 1529387266, 1, 1, 3, 1, 1);
INSERT INTO public.tbl_group VALUES (10, '4 row', '', NULL, NULL, NULL, 1529388016, 1529388016, 1, 1, 6, 1, 1);
INSERT INTO public.tbl_group VALUES (6, 'ghjfgjh 1 2', 'gfjhghj', NULL, NULL, 'bg-color-green', 1529326911, 1529387230, 1, 1, 5, 1, 1);
INSERT INTO public.tbl_group VALUES (3, 'Test group', '', NULL, NULL, 'bg-color-purple', 1485436809, 1529402701, 1, 1, 4, 1, 0);


--
-- Data for Name: tbl_lang; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_lang VALUES (1, 'ru', 1, 1529326958, 1529326982, 1, 1, 1, 1, 0);
INSERT INTO public.tbl_lang VALUES (2, 'en', 1, 1529326970, 1529326986, 1, 1, 2, 1, 1);
INSERT INTO public.tbl_lang VALUES (3, 'es', 0, 1529387651, 1529387651, 1, 1, 2, 1, 0);


--
-- Data for Name: tbl_letter_file; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_mailer; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_mailer VALUES (9, 7, '2', 1, NULL, 'апрвапр', '<div id="container" style=""><table cellspacing="0" cellpadding="0" border="0" align="center" width="644" class="content"><tbody><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><div class="info-region" data-type="web"><table class="default" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" width="494" valign="top" align="left"><div id="bl_595216487" class="edittable" style="position: relative;"></div></td><td class="td" border="0" width="150" valign="top" align="left"><div id="bl_301944283" class="edittable" style="position: relative;"><div class="block-content block-block text-editor info-region-block align-right">undefined</div>
</div></td></tr></tbody></table></div></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="es-header first" data-type="header1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td><td class="td" border="0" width="1%" valign="middle" align="left"><div id="bl_474176812" class="edittable" style="position: relative;"><div class="block-content block-logo align-left header-block"><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="middle" align="left"><div id="bl_890751952" class="edittable" style="position: relative;"><div class="block-content block-name text-editor align-left header-name">The name of the company website 123 4</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="4" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_255115486" class="edittable" style="position: relative;"><div class="block-content block-title text-editor default-title align-left">The main idea of writing</div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="9" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_417382315" class="edittable" style="position: relative;"><div class="block-content block-text text-editor default-text align-left">Good afternoon, [name]<br>
<br>
Insert here the text of your message. In order to have your delivery was effective, try to follow these tips:
<ul>
	<li>Think about what you want to achieve this mailing</li>
	<li>Think about who your recipients</li>
	<li>write so as if you are applying to one person</li>
</ul>
</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" width="1%" valign="top" align="left"><div id="bl_91355679" class="edittable" style="position: relative;"><div class="block-content block-picture default-block align-left"><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_56489150" class="edittable" style="position: relative;"><div class="block-content block-text text-editor default-text align-left">Always say good-bye.</div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="es-footer" data-type="contact1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_6311124" class="edittable" style="position: relative;"><div class="block-content block-sender text-editor align-left footer-text">Sincerely,<br>
&lt;Sender''s name&gt;<br>
&lt;Position of sender&gt;<br>
&lt;Company sender&gt;<br>
&lt;Website sender&gt;</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" width="1%" valign="middle" align="left"><div id="bl_606562402" class="edittable" style="position: relative;"><div class="block-content block-logo align-left footer-block"><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><div id="bl_89844686" class="edittable" data-type="footer" style="position: relative;"><div class="block-text-inner">
<div class="block-content block-block text-editor info-region-block align-center block-text-clicked-processed">You have received this e-mail address [EMAIL], because a client [GROUP].<br>
[UNSUBSCRIBE].</div>
</div>
</div></div></td></tr></tbody></table></div>', '5b28b500ad9e5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL);
INSERT INTO public.tbl_mailer VALUES (10, 3, '4', 1, NULL, 'Test mail', '<div id="container" style=""><table cellspacing="0" cellpadding="0" border="0" align="center" width="644" class="content"><tbody><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><div class="info-region" data-type="web"><table class="default" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" width="494" valign="top" align="left"><div id="bl_97559033" class="edittable" style="position: relative;"></div></td><td class="td" border="0" width="150" valign="top" align="left"><div id="bl_243140584" class="edittable" style="position: relative;"><div class="block-content block-block text-editor info-region-block align-right ">undefined</div>
</div></td></tr></tbody></table></div></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="es-header first" data-type="header1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td><td class="td" border="0" width="1%" valign="middle" align="left"><div id="bl_664216089" class="edittable" style="position: relative;"><div class="block-content block-logo align-left header-block"><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="middle" align="left"><div id="bl_490461539" class="edittable" style="position: relative;"><div class="block-content block-name text-editor align-left header-name">The name of the company website</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="4" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_349600361" class="edittable" style="position: relative;"><div class="block-content block-title text-editor default-title align-left">The main idea of writing</div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="9" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_481281155" class="edittable" style="position: relative;"><div class="block-content block-text text-editor default-text align-left ">Good afternoon, [name]<br>
<br>
Insert here the text of your message. In order to have your delivery was effective, try to follow these tips:
<ul>
	<li>Think about what you want to achieve this mailing</li>
	<li>Think about who your recipients</li>
	<li>write so as if you are applying to one person</li>
</ul>
</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" width="1%" valign="top" align="left"><div id="bl_748263231" class="edittable" style="position: relative;"><div class="block-content block-picture default-block align-left "><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="default" data-type="1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_337769756" class="edittable" style="position: relative;"><div class="block-content block-text text-editor default-text align-left">Always say good-bye.</div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="3" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><table class="es-footer" data-type="contact1" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr><tr><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" valign="top" align="left"><div id="bl_552882530" class="edittable" style="position: relative;"><div class="block-content block-sender text-editor align-left footer-text">Sincerely,<br>
&lt;Sender''s name&gt;<br>
&lt;Position of sender&gt;<br>
&lt;Company sender&gt;<br>
&lt;Website sender&gt;</div>
</div></td><td class="td" border="0" width="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></td><td class="td" border="0" width="1%" valign="middle" align="left"><div id="bl_167541012" class="edittable" style="position: relative;"><div class="block-content block-logo align-left footer-block"><img class="image" src="/builder/images/blank.gif" title="Image" width="201"></div>
</div></td><td class="td" border="0" width="10"><div style="line-height:0; width:10px; height:1px;"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="10" height="1"></div></td></tr><tr><td class="td" border="0" colspan="5" height="10"><img src="http://sender.local/public/builder/images/blank.gif" class="img" width="1" height="10"></td></tr></tbody></table></div></td></tr><tr><td class="row-block" align="left" valign="top" border="0" class="td"><div class="content-block"><div id="bl_299296277" class="edittable" data-type="footer" style="position: relative;"><div class="block-text-inner">
<div class="block-content block-block text-editor info-region-block align-center block-text-clicked-processed">You have received this e-mail address [EMAIL], because a client [GROUP].<br>
[UNSUBSCRIBE].</div>
</div>
</div></div></td></tr></tbody></table></div>', '5b28b688597a9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL);


--
-- Data for Name: tbl_mailer_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_mailer_data VALUES (7, 2, 'nikalas9@ya.ru', 4, 10, NULL, 1529404377, NULL, NULL, NULL, NULL, NULL, '5b28d918282f2', NULL, NULL, '4106cb7ffc519d7b7885cb6613cd558b@swift.generated', NULL, NULL, 1);
INSERT INTO public.tbl_mailer_data VALUES (8, 4, 'nikalas98542@ya.ru', 4, 10, NULL, 1529404420, NULL, NULL, NULL, NULL, NULL, '5b28d91d6ab85', NULL, NULL, '04a251eee9c097cd0f8f505bf95663af@swift.generated', NULL, NULL, 1);
INSERT INTO public.tbl_mailer_data VALUES (9, 5, 'nikalas9@gmail.com', 4, 10, NULL, 1529404424, NULL, NULL, NULL, NULL, NULL, '5b28d91fb7fd2', NULL, NULL, '12aa0aa433ddea69aa61ae1a1e59c7e3@swift.generated', NULL, NULL, 1);


--
-- Data for Name: tbl_migration_drop; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_migration_drop VALUES ('m000000_000000_base', 1485434509);
INSERT INTO public.tbl_migration_drop VALUES ('m170126_102314_mailer_base', 1485434517);
INSERT INTO public.tbl_migration_drop VALUES ('m150214_044831_init_user', 1485434691);


--
-- Data for Name: tbl_pages; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_profile; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_profile VALUES (1, 1, '2017-01-26 12:44:51', NULL, 'the one', NULL);


--
-- Data for Name: tbl_role; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_role VALUES (1, 'Admin', '2017-01-26 12:44:51', NULL, 1);
INSERT INTO public.tbl_role VALUES (2, 'User', '2017-01-26 12:44:51', NULL, 0);


--
-- Data for Name: tbl_templates; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_tmp_link; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_tmp_link VALUES (1, 6, 'http://google.com', 'cb1e211a707087926ea3ad2444594b4b', NULL, NULL);
INSERT INTO public.tbl_tmp_link VALUES (2, NULL, 'http://google.com', '58c6b431e7ddb', NULL, NULL);


--
-- Data for Name: tbl_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tbl_user VALUES (1, 1, 1, 'neo@neo.com', 'neo', '$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O', 'HY_OtOb0xwmRblRrTfKkSvc2viDsgil6', '-jVo-5ebYd9EqvvyJ_trJwKxoYBi3mL8', '127.0.0.1', '2018-06-19 10:03:19', NULL, '2017-01-26 12:44:51', NULL, NULL, NULL);


--
-- Data for Name: tbl_user_auth; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: tbl_user_token; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: log_ask_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.log_ask_id_seq', 1, false);


--
-- Name: tbl_account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_account_id_seq', 2, true);


--
-- Name: tbl_base_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_base_id_seq', 4, true);


--
-- Name: tbl_black_list_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_black_list_id_seq', 1, false);


--
-- Name: tbl_city_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_city_id_seq', 1, false);


--
-- Name: tbl_clients_base_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_clients_base_id_seq', 7, true);


--
-- Name: tbl_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_clients_id_seq', 5, true);


--
-- Name: tbl_clients_param_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_clients_param_id_seq', 2, true);


--
-- Name: tbl_country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_country_id_seq', 1, false);


--
-- Name: tbl_files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_files_id_seq', 1, true);


--
-- Name: tbl_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_group_id_seq', 10, true);


--
-- Name: tbl_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_lang_id_seq', 3, true);


--
-- Name: tbl_letter_file_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_letter_file_id_seq', 1, false);


--
-- Name: tbl_mailer_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_mailer_data_id_seq', 9, true);


--
-- Name: tbl_mailer_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_mailer_id_seq', 10, true);


--
-- Name: tbl_pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pages_id_seq', 1, false);


--
-- Name: tbl_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_profile_id_seq', 1, true);


--
-- Name: tbl_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_role_id_seq', 2, true);


--
-- Name: tbl_templates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_templates_id_seq', 1, false);


--
-- Name: tbl_tmp_link_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_tmp_link_id_seq', 2, true);


--
-- Name: tbl_user_auth_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_user_auth_id_seq', 1, false);


--
-- Name: tbl_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_user_id_seq', 1, true);


--
-- Name: tbl_user_token_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_user_token_id_seq', 1, false);


--
-- Name: log_ask log_ask_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_ask
    ADD CONSTRAINT log_ask_pkey PRIMARY KEY (id);


--
-- Name: migration_drop migration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migration_drop
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: tbl_account tbl_account_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_account
    ADD CONSTRAINT tbl_account_pkey PRIMARY KEY (id);


--
-- Name: tbl_base tbl_base_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_base
    ADD CONSTRAINT tbl_base_pkey PRIMARY KEY (id);


--
-- Name: tbl_black_list tbl_black_list_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_black_list
    ADD CONSTRAINT tbl_black_list_pkey PRIMARY KEY (id);


--
-- Name: tbl_city_drop tbl_city_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_city_drop
    ADD CONSTRAINT tbl_city_pkey PRIMARY KEY (id);


--
-- Name: tbl_clients_base tbl_clients_base_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients_base
    ADD CONSTRAINT tbl_clients_base_pkey PRIMARY KEY (id);


--
-- Name: tbl_clients_param tbl_clients_param_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients_param
    ADD CONSTRAINT tbl_clients_param_pkey PRIMARY KEY (id);


--
-- Name: tbl_clients tbl_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_clients
    ADD CONSTRAINT tbl_clients_pkey PRIMARY KEY (id);


--
-- Name: tbl_country_drop tbl_country_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_country_drop
    ADD CONSTRAINT tbl_country_pkey PRIMARY KEY (id);


--
-- Name: tbl_files tbl_files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_files
    ADD CONSTRAINT tbl_files_pkey PRIMARY KEY (id);


--
-- Name: tbl_group tbl_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_group
    ADD CONSTRAINT tbl_group_pkey PRIMARY KEY (id);


--
-- Name: tbl_lang tbl_lang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_lang
    ADD CONSTRAINT tbl_lang_pkey PRIMARY KEY (id);


--
-- Name: tbl_letter_file tbl_letter_file_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_letter_file
    ADD CONSTRAINT tbl_letter_file_pkey PRIMARY KEY (id);


--
-- Name: tbl_mailer_data tbl_mailer_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_mailer_data
    ADD CONSTRAINT tbl_mailer_data_pkey PRIMARY KEY (id);


--
-- Name: tbl_mailer tbl_mailer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_mailer
    ADD CONSTRAINT tbl_mailer_pkey PRIMARY KEY (id);


--
-- Name: tbl_migration_drop tbl_migration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_migration_drop
    ADD CONSTRAINT tbl_migration_pkey PRIMARY KEY (version);


--
-- Name: tbl_pages tbl_pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pages
    ADD CONSTRAINT tbl_pages_pkey PRIMARY KEY (id);


--
-- Name: tbl_profile tbl_profile_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_profile
    ADD CONSTRAINT tbl_profile_pkey PRIMARY KEY (id);


--
-- Name: tbl_role tbl_role_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_role
    ADD CONSTRAINT tbl_role_pkey PRIMARY KEY (id);


--
-- Name: tbl_templates tbl_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_templates
    ADD CONSTRAINT tbl_templates_pkey PRIMARY KEY (id);


--
-- Name: tbl_tmp_link tbl_tmp_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_tmp_link
    ADD CONSTRAINT tbl_tmp_link_pkey PRIMARY KEY (id);


--
-- Name: tbl_user_auth tbl_user_auth_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_auth
    ADD CONSTRAINT tbl_user_auth_pkey PRIMARY KEY (id);


--
-- Name: tbl_user tbl_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user
    ADD CONSTRAINT tbl_user_pkey PRIMARY KEY (id);


--
-- Name: tbl_user_token tbl_user_token_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_token
    ADD CONSTRAINT tbl_user_token_pkey PRIMARY KEY (id);


--
-- Name: tbl_user_auth_provider_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX tbl_user_auth_provider_id ON public.tbl_user_auth USING btree (provider_id);


--
-- Name: tbl_user_email; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX tbl_user_email ON public.tbl_user USING btree (email);


--
-- Name: tbl_user_token_token; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX tbl_user_token_token ON public.tbl_user_token USING btree (token);


--
-- Name: tbl_user_username; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX tbl_user_username ON public.tbl_user USING btree (username);


--
-- Name: tbl_profile tbl_profile_user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_profile
    ADD CONSTRAINT tbl_profile_user_id FOREIGN KEY (user_id) REFERENCES public.tbl_user(id);


--
-- Name: tbl_user_auth tbl_user_auth_user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_auth
    ADD CONSTRAINT tbl_user_auth_user_id FOREIGN KEY (user_id) REFERENCES public.tbl_user(id);


--
-- Name: tbl_user tbl_user_role_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user
    ADD CONSTRAINT tbl_user_role_id FOREIGN KEY (role_id) REFERENCES public.tbl_role(id);


--
-- Name: tbl_user_token tbl_user_token_user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_token
    ADD CONSTRAINT tbl_user_token_user_id FOREIGN KEY (user_id) REFERENCES public.tbl_user(id);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

