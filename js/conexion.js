// backend/db.js
const { Pool } = require('pg');

const pool = new Pool({
  user: 'bahamutuser',
  host: '192.168.1.190',
  database: 'bahamut',
  password: 'Clave_00',
  port: 5432, // Puerto por defecto de PostgreSQL
});

module.exports = pool;
