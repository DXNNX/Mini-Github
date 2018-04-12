create keyspace github WITH REPLICATION = { 'class' : 'NetworkTopologyStrategy', 'datacenter1' : 2 };
create type archivoty(idarchivo text, nombre text);
create table proyecto(idProyecto text,owner text,suscriptores list<text>, branch text, secuencia list<frozen <tuple<text,text,text,list<frozen <archivoTy>>>>>,parentBranch text,primary key(owner,idProyecto,branch));
create type archivoStruct(idArchivo text,version text,comentario text,usuario text);
create table archivoHist(projectname text,branchname text,docname text,owner text,historial list<frozen <archivostruct>>,primary key(projectname, branchname,docname,owner));