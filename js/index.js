const express = require('express');
const pool = require('./db');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3001;

app.use(cors());
app.use(bodyParser.json());

app.post('/login', async (req, res) => {
  const { nombre_usuario, contraseña } = req.body;

  try {
    const result = await pool.query(
      'SELECT * FROM usuarios WHERE nombre_usuario = $1 AND contraseña = $2',
      [nombre_usuario, contraseña]
    );

    if (result.rows.length > 0) {
      res.json({ success: true, mensaje: 'Login correcto' });
    } else {
      res.json({ success: false, mensaje: 'Usuario o contraseña incorrectos' });
    }
  } catch (error) {
    console.error(error);
    res.status(500).json({ success: false, mensaje: 'Error del servidor' });
  }
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en http://localhost:${PORT}`);
});
