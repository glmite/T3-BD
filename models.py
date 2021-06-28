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

	#relacion pais usuario
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