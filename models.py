from datetime import datetime
from flask_sqlalchemy import SQLAlchemy
# Importamos para realizar consultas personalizadas
from sqlalchemy import text
from sqlalchemy.sql.elements import False_
from sqlalchemy.sql.expression import false, true

db = SQLAlchemy()

#Creamos entidad pais
class Pais(db.Model):
	_tablename_= 'pais'
	cod_pais = db.Column(db.Integer, primary_key=True) #primary key
	nombre = db.Column(db.String(45), nullable=False) #atributo no nulo

	#relacion pais usuario(creo que no es necesario)
	usuario = db.relationship('Usuario', lazy='dynamic')

	#Instancia un pais y lo guarda en la base de datos
	@classmethod
	def create(cls, nombre):
		pais = Pais(nombre=nombre)
		return pais.save()

	#Guarda el pais
	def save(self):
		try:
			db.session.add(self)
			db.session.commit()
			return self
		except:
			return False

	def json(self):
		return {
			'cod_pais': self.cod_pais,
			'nombre': self.nombre
		}

	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()
			return True
		except:
			return False

#Hacer entidad moneda
class Moneda(db.Model):
	_tablename_= 'moneda'
	id = db.Column(db.Integer, primary_key=True) #primary key
	sigla = db.Column(db.String(10), nullable=False) #atributo no nulo
	nombre = db.Column(db.String(80), nullable=False) #atributo no nulo

	#relación moneda y sus precio
	precios = db.relationship('Precio_Moneda', lazy='dynamic')

	#relación moneda y usuario
	usuario_tiene_moneda = db.relationship('Usuario_tiene_moneda', lazy='dynamic')

	#Instancia moneda
	@classmethod
	def create(cls, nombre,sigla):
		moneda = Moneda(nombre=nombre, sigla=sigla)
		return moneda.save()

	#Guarda moneda en base de datos
	def save(self):
		try:
			db.session.add(self)
			db.session.commit()
			return self
		except:
			return False

	def json(self):
		return {
			'id': self.id,
			'sigla': self.sigla,
			'nombre': self.nombre
		}

	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()
			return True
		except:
			return False


#Hacer entidad precio_moneda
class Precio_Moneda(db.Model):
	_tablename_= 'precio_moneda'
	id_moneda = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True ) #PK y FK
	fecha = db.Column(db.DateTime(), default=db.func.current_timestamp(),primary_key= True) #PK
	valor = db.Column(db.Float, nullable=False) #atributo flotante no nulo

	#Relación con moneda
	moneda = db.relationship("Moneda")

	#Instancia un precio a la moneda
	@classmethod
	def create(cls,id_moneda,valor):
		precio = Precio_Moneda(valor=valor,id_moneda=id_moneda)
		return precio.save()

	#Guarda el pais
	def save(self):
		try:
			db.session.add(self)
			db.session.commit()
			return self
		except:
			return False

	def json(self):
		return {
			'id_moneda': self.id_moneda,
			'fecha': self.fecha,
			'valor': self.valor
		}

	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()
			return True
		except:
			return False

#Creamos entidad cuenta_bancaria(asumo que el numero se hace solo)
class Cuenta_bancaria(db.Model):
	_tablename_= 'cuenta_bancaria'
	numero_cuenta = db.Column(db.Integer, primary_key=True) #primary key
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), nullable=False) #atributo no nulo, FK
	balance = db.Column(db.Float, nullable=False) #atributo no nulo

	#relacion cuenta_bancaria y usuario
	usuario = db.relationship('Usuario', lazy='dynamic')

	#Instancia una cuenta bancaria y lo guarda en la base de datos
	@classmethod
	def create(cls, id_usuario,balance):
		pais = Cuenta_bancaria(id_usuario=id_usuario,balance=balance)
		return pais.save()

	#Guarda la cuenta bancaria
	def save(self):
		try:
			db.session.add(self)
			db.session.commit()
			return self
		except:
			return False

	def json(self):
		return {
			'numero_cuenta': self.numero_cuenta,
			'id_usuario': self.id_usuario,
			'balance': self.balance
		}

	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()
			return True
		except:
			return False


# Creamos la entidad Usuario
class Usuario(db.Model):
	__tablename__ = 'usuario'
	id = db.Column(db.Integer, primary_key=True) #PK
	nombre = db.Column(db.String(50), nullable=False) #NOT NULL
	apellido = db.Column(db.String(50), nullable=False)#NOT NULL
	correo = db.Column(db.String(50), nullable=False)#NOT NULL
	contraseña = db.Column(db.String(50), nullable=False)#NOT NULL
	pais = db.Column(db.Integer, db.ForeignKey('pais.cod_pais'),nullable=False) #FK, NOT NULL
	fecha_registro = db.Column(db.DateTime(), nullable=False, default=db.func.current_timestamp()) #NOT NULL

	#relación usuario y cuenta_bancaria
	cuentas_bancarias = db.relationship('Cuenta_bancaria', lazy='dynamic')

	#relación usuario y pais (creo que esta no se pone, o si es que se pone, no es dynamic
	#paises = db.relationship('Pais', lazy='dynamic')

	@classmethod
	def create(cls, username):
		# Instanciamos un nuevo usuario y lo guardamos en la bd
		nombre = Usuario(nombre=nombre)
		return nombre.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False
	def json(self):
		return {
			'id': self.id,
			'nombre': self.nombre,
			'apellido': self.apellido,
                        'correo': self.correo,
                        'contraseña': self.contraseña,
                        'pais': self.pais,
                        'fecha_registro': self.fecha_registro
		}
	def update(self):
		self.save()
	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()

			return True
		except:
			return False

# Creamos la entidad Usuario_tiene_moneda
class Usuario_tiene_moneda(db.Model):
	__tablename__ = 'usuario_tiene_moneda'
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), primary_key=True) #PK Y FK
	id_moneda = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True ) #PK Y FK
	balance = db.Column(db.Float, nullable=False) #NOT NULL

	#relación usuario y usuario_tiene_moneda
	usuario = db.relationship('Usuario', lazy='dynamic')

	#relación moneda y usuario_tiene_moneda
	moneda = db.relationship('Moneda', lazy='dynamic')

	@classmethod
	def create(cls, id_usuario,id_moneda,balance):
		usuario_moneda = Usuario_tiene_moneda(id_usuario=id_usuario,id_moneda=id_moneda,balance=balance)
		return usuario_moneda.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()
			return self
		except:
			return False
	def json(self):
		return {
			'id_usuario': self.id_usuario,
			'id_moneda': self.id_moneda,
			'balance': self.balance,
		}
	def update(self):
		self.save()
	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()
			return True
		except:
			return False
