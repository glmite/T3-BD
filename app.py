from flask import Flask
from flask import jsonify
from config import config
from models import Moneda, Pais, Precio_Moneda,db
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
def update_user(id):
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
@app.route('/api/precio/', methods=['POST'])
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


if __name__ == '__main__':
	app.run(debug=True)