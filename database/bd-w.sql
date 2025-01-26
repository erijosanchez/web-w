-- Tabla de Marcas (sin cambios)
CREATE TABLE brands (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT,
    logo_url VARCHAR(255),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_brand_slug (slug),
    INDEX idx_brand_active (is_active)
);

-- Tabla de Categorías (sin cambios)
CREATE TABLE categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    parent_id BIGINT NULL,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT,
    level INT NOT NULL DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id),
    INDEX idx_category_parent (parent_id),
    INDEX idx_category_slug (slug),
    INDEX idx_category_active (is_active)
);

-- Tabla de Productos (ahora es el modelo base)
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    brand_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(300) NOT NULL UNIQUE,
    description TEXT,
    base_price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(id),
    INDEX idx_product_brand (brand_id),
    INDEX idx_product_slug (slug),
    INDEX idx_product_active (is_active)
);

-- Tabla de Colores
CREATE TABLE colors (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    hex_code VARCHAR(7) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Tallas
CREATE TABLE sizes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    value VARCHAR(10) NOT NULL UNIQUE,
    display_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- NUEVA: Tabla de Variantes de Producto
CREATE TABLE product_variants (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    color_id BIGINT NOT NULL,
    sku VARCHAR(50) NOT NULL UNIQUE,
    additional_price DECIMAL(10,2) DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (color_id) REFERENCES colors(id),
    INDEX idx_variant_product (product_id),
    INDEX idx_variant_sku (sku)
);

-- NUEVA: Tabla de Imágenes de Variantes
CREATE TABLE variant_images (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    variant_id BIGINT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT false,
    display_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id),
    INDEX idx_variant_images (variant_id)
);

-- MODIFICADA: Tabla de Inventario (ahora relacionada con variantes)
CREATE TABLE inventory (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    variant_id BIGINT NOT NULL,
    size_id BIGINT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id),
    FOREIGN KEY (size_id) REFERENCES sizes(id),
    UNIQUE KEY uk_variant_size (variant_id, size_id),
    INDEX idx_inventory_stock (stock)
);

-- Tabla de relación Productos-Categorías (sin cambios)
CREATE TABLE product_categories (
    product_id BIGINT NOT NULL,
    category_id BIGINT NOT NULL,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Tabla de Usuarios (sin cambios)
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_user_email (email),
    INDEX idx_user_active (is_active)
);

-- Tabla de Direcciones (sin cambios)
CREATE TABLE addresses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    is_default BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_address_user (user_id)
);

-- Tabla de Cupones (sin cambios)
CREATE TABLE coupons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    discount_type ENUM('percentage', 'fixed') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    minimum_purchase DECIMAL(10,2),
    starts_at TIMESTAMP NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    usage_limit INT,
    times_used INT DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_coupon_code (code),
    INDEX idx_coupon_active (is_active)
);

-- Tabla de Estados de Pedido (sin cambios)
CREATE TABLE order_statuses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    display_order INT NOT NULL
);

-- Tabla de Pedidos (sin cambios)
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    address_id BIGINT NOT NULL,
    status_id BIGINT NOT NULL,
    coupon_id BIGINT,
    subtotal DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    shipping_cost DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (address_id) REFERENCES addresses(id),
    FOREIGN KEY (status_id) REFERENCES order_statuses(id),
    FOREIGN KEY (coupon_id) REFERENCES coupons(id),
    INDEX idx_order_user (user_id),
    INDEX idx_order_status (status_id)
);

-- MODIFICADA: Tabla de Detalles de Pedido (ahora usa variantes)
CREATE TABLE order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT NOT NULL,
    variant_id BIGINT NOT NULL,
    size_id BIGINT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(id),
    FOREIGN KEY (size_id) REFERENCES sizes(id),
    INDEX idx_order_item_order (order_id)
);

-- MODIFICADA: Tabla de Reseñas (ahora relacionada con variantes)
CREATE TABLE reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    variant_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    order_id BIGINT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    is_verified BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    UNIQUE KEY uk_user_variant_order (user_id, variant_id, order_id),
    INDEX idx_review_product (product_id),
    INDEX idx_review_variant (variant_id),
    INDEX idx_review_rating (rating)
);

-- Tabla de Carritos de Compra (sin cambios)
CREATE TABLE carts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    session_id VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_cart_user (user_id),
    INDEX idx_cart_session (session_id)
);

-- MODIFICADA: Tabla de Items del Carrito (ahora usa variantes)
CREATE TABLE cart_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    cart_id BIGINT NOT NULL,
    variant_id BIGINT NOT NULL,
    size_id BIGINT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(id),
    FOREIGN KEY (size_id) REFERENCES sizes(id),
    UNIQUE KEY uk_cart_variant_size (cart_id, variant_id, size_id),
    INDEX idx_cart_item_cart (cart_id)
);

-- Tabla de Roles y Permisos para Administración
CREATE TABLE admin_roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE admin_permissions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE role_permissions (
    role_id BIGINT NOT NULL,
    permission_id BIGINT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES admin_roles(id),
    FOREIGN KEY (permission_id) REFERENCES admin_permissions(id)
);

CREATE TABLE admin_users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT true,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (role_id) REFERENCES admin_roles(id),
    INDEX idx_admin_email (email),
    INDEX idx_admin_active (is_active)
);

-- Tablas para Sliders y Banners
CREATE TABLE slider_locations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE sliders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    location_id BIGINT NOT NULL,
    title VARCHAR(100) NOT NULL,
    subtitle TEXT,
    image_desktop VARCHAR(255) NOT NULL,
    image_mobile VARCHAR(255) NOT NULL,
    link_url VARCHAR(255),
    button_text VARCHAR(50),
    background_color VARCHAR(7),
    text_color VARCHAR(7),
    display_order INT NOT NULL,
    starts_at TIMESTAMP NULL,
    ends_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES slider_locations(id),
    INDEX idx_slider_active (is_active),
    INDEX idx_slider_dates (starts_at, ends_at)
);

-- Tablas para Secciones Personalizadas
CREATE TABLE section_types (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    available_fields JSON NOT NULL
);

CREATE TABLE page_sections (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    type_id BIGINT NOT NULL,
    title VARCHAR(100),
    subtitle TEXT,
    content JSON,
    background_type ENUM('color', 'image') DEFAULT 'color',
    background_value VARCHAR(255),
    display_order INT NOT NULL,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES section_types(id),
    INDEX idx_section_active (is_active)
);

-- Tabla para Menús Dinámicos
CREATE TABLE menus (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    location VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    items JSON NOT NULL,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tablas para SEO y Metadatos
CREATE TABLE seo_metadata (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    page_type VARCHAR(50) NOT NULL,
    reference_id BIGINT NULL,
    title VARCHAR(60) NOT NULL,
    description VARCHAR(160),
    keywords VARCHAR(255),
    og_title VARCHAR(95),
    og_description VARCHAR(200),
    og_image VARCHAR(255),
    canonical_url VARCHAR(255),
    structured_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_page_reference (page_type, reference_id)
);

-- Tabla para Redirecciones
CREATE TABLE redirects (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    source_url VARCHAR(255) NOT NULL UNIQUE,
    target_url VARCHAR(255) NOT NULL,
    redirect_type ENUM('301', '302') DEFAULT '301',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_redirect_source (source_url)
);

-- Tabla para Configuración General
CREATE TABLE site_settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(50) NOT NULL,
    key_name VARCHAR(100) NOT NULL,
    value_type ENUM('string', 'number', 'boolean', 'json') NOT NULL,
    value TEXT NOT NULL,
    is_public BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_setting_key (category, key_name)
);

-- Tabla para Temas y Estilos
CREATE TABLE theme_settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    primary_color VARCHAR(7) NOT NULL,
    secondary_color VARCHAR(7) NOT NULL,
    accent_color VARCHAR(7),
    text_color VARCHAR(7) NOT NULL,
    background_color VARCHAR(7) NOT NULL,
    button_style JSON,
    typography_settings JSON,
    custom_css TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla para Íconos y Activos
CREATE TABLE assets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('icon', 'image', 'document', 'other') NOT NULL,
    name VARCHAR(100) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_size INT NOT NULL,
    dimensions JSON NULL,
    tags JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_asset_type (type)
);

-- Tabla para Analíticas
CREATE TABLE analytics_events (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    event_type VARCHAR(50) NOT NULL,
    event_data JSON NOT NULL,
    user_id BIGINT NULL,
    session_id VARCHAR(100),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_analytics_type (event_type),
    INDEX idx_analytics_date (created_at)
);

-- Tabla para Caché
CREATE TABLE cache_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    cache_key VARCHAR(255) NOT NULL UNIQUE,
    value LONGTEXT NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_cache_expiry (expires_at)
);
-- Tabla para Categorías de Reportes
CREATE TABLE report_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    display_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para Tipos de Reportes Predefinidos
CREATE TABLE report_types (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    query_template TEXT NOT NULL,
    parameters JSON,  -- Define los parámetros que acepta el reporte
    available_columns JSON NOT NULL, -- Columnas que puede mostrar el reporte
    default_columns JSON NOT NULL,   -- Columnas mostradas por defecto
    chart_options JSON,             -- Configuración para visualizaciones
    permissions JSON,               -- Permisos necesarios para ejecutar
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES report_categories(id),
    INDEX idx_report_category (category_id),
    INDEX idx_report_active (is_active)
);

-- Tabla para Reportes Personalizados
CREATE TABLE custom_reports (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT NOT NULL,
    created_by BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    query_definition JSON NOT NULL,  -- Definición del reporte en formato amigable
    raw_query TEXT,                 -- Query SQL generada
    parameters JSON,
    columns_config JSON NOT NULL,
    chart_config JSON,
    is_public BOOLEAN DEFAULT false,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES report_categories(id),
    FOREIGN KEY (created_by) REFERENCES admin_users(id),
    INDEX idx_custom_report_category (category_id),
    INDEX idx_custom_report_creator (created_by)
);

-- Tabla para Programación de Reportes
CREATE TABLE report_schedules (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    report_type ENUM('predefined', 'custom') NOT NULL,
    report_id BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    parameters JSON,                -- Parámetros específicos para esta programación
    schedule_type ENUM('once', 'daily', 'weekly', 'monthly') NOT NULL,
    schedule_config JSON NOT NULL,  -- Configuración específica del calendario
    output_format ENUM('pdf', 'excel', 'csv', 'json') NOT NULL,
    recipients JSON NOT NULL,       -- Lista de destinatarios y sus preferencias
    is_active BOOLEAN DEFAULT true,
    last_run TIMESTAMP NULL,
    next_run TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_schedule_next_run (next_run),
    INDEX idx_schedule_active (is_active)
);

-- Tabla para Reportes Generados
CREATE TABLE generated_reports (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    schedule_id BIGINT NULL,        -- NULL si fue generado manualmente
    report_type ENUM('predefined', 'custom') NOT NULL,
    report_id BIGINT NOT NULL,
    generated_by BIGINT NOT NULL,   -- Usuario que generó o programación
    name VARCHAR(255) NOT NULL,
    parameters JSON,                -- Parámetros usados en la generación
    format VARCHAR(10) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size BIGINT NOT NULL,
    row_count INT NOT NULL,
    execution_time INT NOT NULL,    -- Tiempo en segundos
    status ENUM('success', 'partial', 'error') NOT NULL,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,      -- Fecha de expiración del archivo
    FOREIGN KEY (schedule_id) REFERENCES report_schedules(id),
    FOREIGN KEY (generated_by) REFERENCES admin_users(id),
    INDEX idx_report_generated (created_at),
    INDEX idx_report_expiry (expires_at)
);

-- Tabla para Compartir Reportes
CREATE TABLE report_shares (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    generated_report_id BIGINT NOT NULL,
    shared_by BIGINT NOT NULL,
    share_type ENUM('link', 'email') NOT NULL,
    recipient VARCHAR(255) NULL,    -- Email del destinatario si es compartido por email
    access_token VARCHAR(100) NULL, -- Token único para acceso por link
    permissions JSON NOT NULL,      -- Permisos de visualización/descarga
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_report_id) REFERENCES generated_reports(id),
    FOREIGN KEY (shared_by) REFERENCES admin_users(id),
    INDEX idx_share_token (access_token),
    INDEX idx_share_expiry (expires_at)
);

-- Tabla para Favoritos y Accesos Rápidos
CREATE TABLE report_favorites (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    report_type ENUM('predefined', 'custom') NOT NULL,
    report_id BIGINT NOT NULL,
    display_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id),
    UNIQUE KEY uk_user_report (user_id, report_type, report_id)
);

-- Tabla para Dashboard de Reportes
CREATE TABLE report_dashboards (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    layout_config JSON NOT NULL,    -- Configuración del diseño del dashboard
    is_public BOOLEAN DEFAULT false,
    created_by BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_users(id)
);

-- Tabla para Widgets del Dashboard
CREATE TABLE dashboard_widgets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    dashboard_id BIGINT NOT NULL,
    report_type ENUM('predefined', 'custom') NOT NULL,
    report_id BIGINT NOT NULL,
    widget_type ENUM('chart', 'table', 'metric', 'list') NOT NULL,
    title VARCHAR(100) NOT NULL,
    config JSON NOT NULL,           -- Configuración específica del widget
    position_config JSON NOT NULL,  -- Posición y tamaño en el dashboard
    refresh_interval INT NULL,      -- Intervalo de actualización en minutos
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dashboard_id) REFERENCES report_dashboards(id),
    INDEX idx_widget_dashboard (dashboard_id)
);

-- Tabla para Registro de Ejecución de Reportes
CREATE TABLE report_execution_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    report_type ENUM('predefined', 'custom') NOT NULL,
    report_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    parameters JSON,
    execution_time INT NOT NULL,    -- Tiempo en milisegundos
    row_count INT NOT NULL,
    status ENUM('success', 'error') NOT NULL,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id),
    INDEX idx_execution_date (created_at)
);