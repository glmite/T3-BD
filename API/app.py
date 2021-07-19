from flask import Flask
from flask import jsonify
from config import config
from models import Usuario, Moneda, Pais, Cuenta_bancaria, Precio_Moneda,Usuario_tiene_moneda, db
from flask import request

def create_app(enviroment):
	app = Flask(__name__)
	app.config.from_object(enviroment)
	with app.app_context():
		db.init_app(app)
		db.create_all()
	return app

enviroment = config['development']
app = create_app(enviroment)

#######ENTIDAD PAISES##########
#Listar
@app.route('/api/pais', methods=['GET'])
def get_pais():
	paises = [ pais.json() for pais in Pais.query.all() ]
	return jsonify({'paises': paises })

#Insertar un pais
@app.route('/api/pais', methods=['POST'])
def create_pais():
	json= request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'El formato está mal'}), 400
	pais= Pais.create(json['nombre'])
	return jsonify({'pais': pais.json()})

#Actualizar paises de base de datos
@app.route('/api/pais/<cod_pais>', methods=['PUT'])
def update_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'message': 'User does not exists'}), 404

	json = request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400

	pais.nombre = json['nombre']

	pais.update()

	return jsonify({'pais': pais.json() })

# Eliminar un usuario con codigo pais = cod_pais
@app.route('/api/pais/<cod_pais>', methods=['DELETE'])
def delete_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'message': 'El pais no existe'}), 404

	pais.delete()

	return jsonify({'pais': pais.json() })

######### ENTIDAD MONEDAS ###########
#LISTAR
@app.route('/api/moneda', methods=['GET'])
def get_moneda():
	monedas = [ moneda.json() for moneda in Moneda.query.all() ]
	return jsonify({'monedas': monedas })

#INSERTAR
@app.route('/api/moneda', methods=['POST'])
def create_moneda():
	json= request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'El formato está mal'}), 400
	moneda= Moneda.create(json['nombre'],json['sigla'])
	return jsonify({'moneda': moneda.json()})

 #ELIMINAR
 # Endpoint para eliminar el MONEDA con id igual a <id>
@app.route('/api/moneda/<id>', methods=['DELETE'])
def delete_moneda(id):
	moneda = Moneda.query.filter_by(id=id).first()
	if moneda is None:
		return jsonify({'message': 'La moneda no existe'}), 404

	moneda.delete()

	return jsonify({'moneda': moneda.json() })

 #ACTUALIZAR
 # Endpoint para actualizar los datos de un usuario en la bd
 #debo actualizar sigla, nombre
@app.route('/api/moneda/<id>', methods=['PUT'])
def update_moneda(id):
	moneda = Moneda.query.filter_by(id=id).first()
	if moneda is None:
		return jsonify({'message': 'Moneda does not exists'}), 404

	json = request.get_json(force=True)

	##Supongo que se actualizan los 2
	if (json.get('nombre') is None) and (json.get('sigla') is None):
		return jsonify({'message': 'Bad request'}), 400
	moneda.nombre = json['nombre']
	moneda.sigla= json['sigla']

	moneda.update()

	return jsonify({'moneda': moneda.json() })


##### PRECIO_MONEDA DEPENDE DE MONEDA
#LISTAR
@app.route('/api/precio', methods=['GET'])
def get_precios():
	precios = [ precio.json() for precio in Precio_Moneda.query.all() ]
	return jsonify({'precios': precios })

#INSERTAR
@app.route('/api/precio', methods=['POST'])
def create_precio():
	json = request.get_json(force=True)

	if json.get('id_moneda') is None:
		return jsonify({'message': 'El formato está mal'}), 400

	precio = Precio_Moneda.create(json['id_moneda'],json['valor'])

	return jsonify({'precio': precio.json() })


#ELIMINAR
 # Endpoint para eliminar el MONEDA con id igual a <id>
@app.route('/api/precio/<id>', methods=['DELETE'])
def delete_precio(id_moneda):
	precio = Precio_Moneda.query.filter_by(id_moneda=id_moneda).first()
	if precio is None:
		return jsonify({'message': 'El precio asociado a esa moneda no existe'}), 404

	precio.delete()

	return jsonify({'Precio': precio.json() })

#ACTUALIZAR
@app.route('/api/precio/<id>', methods=['PUT'])
def update_precio(id_moneda):
	precio = Precio_Moneda.query.filter_by(id_moneda=id_moneda).first()
	if precio is None:
		return jsonify({'message': 'El precio asociado a esa moneda no existe'}), 404

	json = request.get_json(force=True)

	if json.get('valor') is None:
		return jsonify({'message': 'Bad request'}), 400
	precio.valor = json['valor']

	precio.update()

	return jsonify({'precio': precio.json() })


######### ENTIDAD CUENTA_BANCARIA ###########
#LISTAR
@app.route('/api/cuenta_bancaria', methods=['GET'])
def get_cuenta():
	cuentas = [ cuenta.json() for cuenta in Cuenta_bancaria.query.all() ]
	return jsonify({'cuentas': cuentas })

#INSERTAR (verifica id_usuario?)
@app.route('/api/cuenta_bancaria', methods=['POST'])
def create_cuenta():
	json= request.get_json(force=True)
	if json.get('id_usuario') is None:
		return jsonify({'message': 'El formato está mal'}), 400
	cuentas= Cuenta_bancaria.create(json['id_usuario'],json['balance'])
	return jsonify({'cuenta_bancaria': cuentas.json()})

 #ELIMINAR
 # Endpoint para eliminar el MONEDA con numero_cuenta igual a <numero_cuenta>
@app.route('/api/cuenta_bancaria/<numero_cuenta>', methods=['DELETE'])
def delete_cuenta(id_usuario):
	cuenta = Cuenta_bancaria.query.filter_by(id_usuario=id_usuario).first()
	if cuenta is None:
		return jsonify({'message': 'La cuenta bancaria no existe'}), 404

	cuenta.delete()

	return jsonify({'cuenta_bancaria': cuenta.json() })

 #ACTUALIZAR
 # Endpoint para actualizar los datos de un usuario en la bd
 #debo actualizar sigla, nombre
@app.route('/api/cuenta_bancaria/<numero_cuenta>', methods=['PUT'])
def update_cuenta(id_usuario):
	cuenta = Cuenta_bancaria.query.filter_by(id_usuario=id_usuario).first()
	if cuenta is None:
		return jsonify({'message': 'Cuenta bancaria does not exists'}), 404

	json = request.get_json(force=True)

	##Se actualiza el balance
	if json.get('balance') is None :
		return jsonify({'message': 'Bad request'}), 400
	cuenta.balance = json['balance']

	cuenta.update()

	return jsonify({'cuenta_bancaria': cuenta.json() })


###### ENTIDAD USUARIO ########

# Endpoint para obtener todos los usuarios
@app.route('/api/usuario', methods=['GET'])
def get_usuario():
	usuarios = [ usuario.json() for usuario in Usuario.query.all() ]
	return jsonify({'usuarios': usuarios })

# Endpoint para insertar un usuario en la bd
@app.route('/api/usuario', methods=['POST'])
def create_usuario():
	json = request.get_json(force=True)

	if json.get('nombre') is None:
		return jsonify({'message': 'El formato está mal'}), 400

	usuario = Usuario.create(json['nombre'],json['apellido'],json['correo'],json['contraseña'], json['pais'])

	return jsonify({'usuario': usuario.json() })

# Endpoint para actualizar los datos de un usuario en la bd
@app.route('/api/usuario/<id>', methods=['PUT'])
def update_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'message': 'User does not exists'}), 404

	json = request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400
	usuario.nombre = json['nombre']

	usuario.update()

	return jsonify({'usuario': usuario.json() })

# Endpoint para eliminar el usuario con id igual a <id>
@app.route('/api/usuario/<id>', methods=['DELETE'])
def delete_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'message': 'El usuario no existe'}), 404

	usuario.delete()
	return jsonify({'usuario': usuario.json() })

#########  USUARIO_TIENE_MONEDA DEPENDE USUARIO Y MONEDA###########
#LISTAR
@app.route('/api/usuario_tiene_moneda', methods=['GET'])
def get_usuario_moneda():
	usuario_monedas = [ usuario_moneda.json() for usuario_moneda in Usuario_tiene_moneda.query.all() ]
	return jsonify({'usuario moneda': usuario_monedas })

#INSERTAR (verifica id_usuario?)
@app.route('/api/usuario_tiene_moneda', methods=['POST'])
def create_usuario_moneda():
	json= request.get_json(force=True)
	if (json.get('id_usuario') is None) and (json.get('id_moneda') is None):
		return jsonify({'message': 'El formato está mal'}), 400
	usuario_monedas = Usuario_tiene_moneda.create(json['id_usuario'],json['id_moneda'],json['balance'])
	return jsonify({'usuario moneda': usuario_monedas.json()})

 #ELIMINAR
 # Endpoint para eliminar el MONEDA con id_usuario e id_moneda igual a <id_usuario,id_moneda>
@app.route('/api/usuario_tiene_moneda/<id_usuario>,<id_moneda>', methods=['DELETE'])
def delete_usuario_moneda(id_usuario,id_moneda):
	cuenta = Usuario_tiene_moneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if cuenta is None:
		return jsonify({'message': 'el usuario moneda no existe'}), 404

	cuenta.delete()

	return jsonify({'usuario_tiene_moneda': cuenta.json() })

 #ACTUALIZAR
 # Endpoint para actualizar los datos de un usuario_tiene_moneda en la bd
 #debo actualizar balance
@app.route('/api/usuario_tiene_moneda/<id_usuario>,<id_moneda>', methods=['PUT'])
def update_usuario_moneda(id_usuario,id_moneda):
	cuenta = Usuario_tiene_moneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if cuenta is None:
		return jsonify({'message': 'el usuario moneda no existe'}), 404

	json = request.get_json(force=True)

	##Se actualiza el balance
	if json.get('balance') is None :
		return jsonify({'message': 'Bad request'}), 400
	cuenta.balance = json['balance']

	cuenta.update()

	return jsonify({'usuario_tiene_moneda': cuenta.json() })

@app.route('/api/consultas/1/<year_reg>', methods=['GET'])
def get_custom1(year):
	usuarios = [dict(usuario) for usuario in Usuario.custom1(year_reg=year_reg).fetchall()]
	return jsonify({'Usuarios': usuarios })

@app.route('/api/consultas/2/<max_balance>', methods=['GET'])
def get_custom2(max_balance):
	cuentas = [dict(cuenta) for cuenta in Cuenta_bancaria.custom2(max_balance=max_balance).fetchall()]
	return jsonify({'Cuentas Bancarias': cuentas })


@app.route('/api/consultas/3/<cod_pais>', methods=['GET'])
def get_custom3(cod_pais):
	usuarios = [dict(usuario) for usuario in Usuario.custom3(cod_pais=cod_pais).fetchall()]
	return jsonify({'Usuarios': usuarios })

if __name__ == '__main__':
	app.run(debug=True)


