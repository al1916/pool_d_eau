#import piscine_csv.py
import csv
import sys
list1 = ' '.join(sys.argv[1:])
print(type(list1))

# -*- coding: utf-8 -*-
#encoding: utf-8
tableconversion=[["50 Nage Libre",0.70,0.70],["100 Nage Libre",1.20,1.50],["200 Nage Libre",2.90,3.60],["400 Nage Libre",6.20,7.70],["800 Nage Libre",12.90,15.90],["1500 Nage Libre",24.50,30.10],["50 Dos",1.30,1.50],["100 Dos",2.30,3.00],["200 Dos",5.40,6.90],["50 Brasse",0.70,1.10],["100 Brasse",1.90,2.50],["200 Brasse",4.50,5.90],["50 Papillon",0.60,0.70],["100 Papillon",1.40,1.40],["200 Papillon",3.30,3.30],["200 4 Nages",3.40,4.10],["400 4 Nages",7.50,9.00]]


def csvtolist(nomdoc):
    """donner le titre du document a convertir avec guillemets"""
    L,data,c=[],[],''
    with open(nomdoc,encoding="UTF8") as f:
        temp = csv.reader(f)
        for ligne in temp:
            L.append(ligne)
    n=len(L)
    for i in range(1,n):
        data.append(L[i][0].split(",")[0].split(";"))
    for i in range(len(data)):
        for j in range(len(data[i])):
            for k in range(len(data[i][j])):
                if data[i][j][k]!='"':
                    c+=data[i][j][k]
            data[i][j]=c
            c=''
            try:
                data[i][j]=int(data[i][j])
            except:
                None
        data[i].append(int(data[i][10][6:10])-data[i][4])
    return data	
def tstr(a):
	return '"'+a+'"'



def conversionbassin(sexe,type_course,taillebassin):
	if sexe=="F":
		a=1
	else:
		a=2
	if taillebassin==50:
		for i in tableconversion:
			if type_course==i[0]:
				return i[a]
	return 0
		
def convtemps(tempsstr,conv):
	if float(tempsstr[6:])-conv>=0:
		return tempsstr[:6]+str(float(tempsstr[6:])-conv)
	else:
		if len(str(int(tempsstr[3:5])-1))==1:
			return tempsstr[:3]+str(0)+str(int(tempsstr[3:5])-1)+":"+str(60+float(tempsstr[6:])-conv)
		else:
			return tempsstr[:3]+str(int(tempsstr[3:5])-1)+":"+str(60+float(tempsstr[6:])-conv)
def convtemps2(temps):
	#print(type(temps.replace(".",":")[3:].split(":")[1]))
	if len(temps.replace(".",":")[3:].split(":")[1])==1:
		return temps.replace(".",":")[3:].split(":")[0]+":"+str(0)+temps.replace(".",":")[3:].split(":")[1]+":"+temps.replace(".",":")[3:].split(":")[2]
	return temps.replace(".",":")[3:]
	
def convtemps3(temps):
	return temps

def ea(a):
    Le=["é","è","ê","ë","Ë","Ê"]
    La=["à","â","ä","Â","Ä"]
    Lo=["ô","ö","Ô","Ö"]
    Li=["î","ï","Ï","Î"]
    Lexception=["ÿ","¨Y","†","¿","½"]
    b=""
    for c in a:
        if c in Le:
            b+="e"
        elif c in La:
            b+="a"
        elif c in Lo:
            b+="o"
        elif c in Li:
            b+="i"
        elif c in Lexception:
            b+=""
        else:
            b+=c
    return b


def inverserdate(a):
	return a[6:10]+"-"+a[3:5]+"-"+a[0:2]
def addtable(file_name):
	"""nom du fichier entre guillemets"""
	compteurcommande=1
	L=csvtolist(file_name)
	#print(file_name.replace("csv","sql"))
	with open("temp.sql",mode="w",encoding="UTF8") as f:
		f.write("ALTER DATABASE Piscine CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n")
		for i in L:
			c1="\ninsert ignore into Nageur(nom,prenom,sexe,birth_date,pays,nom_club) values("+tstr(ea(str(i[2])))+","+tstr(ea(str(i[3])))+","+tstr(str(i[1]))+","+tstr(str(i[4])+"-01-01")+","+tstr(str(i[7]))+","+tstr(str(i[6]).replace(" ","_"))+");"
			f.write(c1)
			c1=""
			c2="\ninsert ignore into Performance(temps,lieu,type_course,taille_bassin,relay,age,pdate,nom,prenom,saison,birth_date) values("+tstr(convtemps(i[9],conversionbassin(i[1],i[0],i[8])))+","+tstr(str(i[11]))+","+tstr(str(i[0]))+","+str(i[8])+","+str(i[13])+","+str(i[14])+","+tstr(inverserdate(str(i[10]).replace("/","-")))+","+tstr(ea(str(i[2])))+","+tstr(ea(str(i[3])))+","+str(i[12])+","+tstr(str(i[4])+"-01-01")+");"
			f.write(c2)
			c2=""
			c3="\ninsert ignore into Club(idclub,nom_club) values("+str(i[5])+","+tstr(str(i[6]).replace(" ","_"))+");\n"
			f.write(c3)
			compteurcommande+=3

	print(compteurcommande)
	return None

a=list1

a=str(a)
print(a)
a="upload/"+a
#a="rankings_natcourse_25.csv"
addtable(a) 	

#def compareage(nom,prenom):
 #   with open("tempreq.sql","w") as f:
  #      f.write("select avg(temps
