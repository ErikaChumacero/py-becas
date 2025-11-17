/* ----- CAMBIAR CONTRASEÑA USUARIO -----------------*/

   create procedure sp_cambiarclaveusuario @ci varchar(10),@claveant varchar(100),@clavenue varchar(100) as
      update persona set contraseña = @clavenue where ci = @ci and contraseña=@claveant 
   go 


/* ----------  CERRAR UNA GESTION ESCOLAR ---------------*/

create procedure sp_CerrarGestion @idgest int as
      update gestion set fechacierre = GETDATE(), estado = '0'  where idgestion = @idgest
go

create procedure sp_AbrirGestion @idgest int as


go

/* ----------  ASIGNAR BECA ESTUDIANTE ---------------*/

create procedure sp_AsignarBeca @ci varchar(10),@codbeca int,@idgest int as
 begin try 
   begin tran   
   
   update inscripcion set codbeca=@codbeca where ci=@ci and idgestion=@idgest 

   declare cursor1 cursor for select m.idmensualidad 
                              from mensualidad m
                              inner join inscripcion i on m.ci = i.ci and m.idcurso = i.idcurso and m.idnivel = i.idnivel
                              where m.ci = @ci and i.idgestion = @idgest
   declare @idmens int

   open cursor1
   fetch cursor1 into @idmens

   while (@@fetch_status=0) 
     begin
        update mensualidad set observacion = 'Beca Aplicada' where idmensualidad = @idmens
       fetch cursor1 into @idmens
    end
  close cursor1
  deallocate cursor1
  commit tran 
end try 
   begin catch  
         rollback tran 
         close cursor1  
         deallocate cursor1 
   end catch  
 
goSS   
/* ----------------  CALCULAR MONTO TOTAL MENSUALIDAD ---------------*/

CREATE PROCEDURE sp_CalcularMontoTotal @iddetalle INT AS

   declare @total smallmoney 
   declare @monto smallmoney
   declare @descuento int

    SELECT @monto = monto, @descuento = descuento FROM detallemensualidad WHERE iddetallemensualidad =@iddetalle;
    
    SET @total = @monto - (@monto * @descuento / 100);
    
    update detallemensualidad set montototal = @total where iddetallemensualidad =@iddetalle 

GO
create procedure sp_QuitarBeca @ci varchar(10),@idgest int as
 
 begin try 
   begin tran    

         update inscripcion set codbeca=NULL where ci=@ci and idgestion=@idgest 

         declare cursor1 cursor for select m.idmensualidad 
                                    from mensualidad m
                                    inner join inscripcion i on m.ci = i.ci and m.idcurso = i.idcurso and m.idnivel = i.idnivel
                                    where m.ci = @ci and i.idgestion = @idgest
         declare @idmens int

         open cursor1
         fetch cursor1 into @idmens

         while (@@fetch_status=0) 
           begin
              update mensualidad set observacion = 'Beca Quitada' where idmensualidad = @idmens
             fetch cursor1 into @idmens
          end
        close cursor1
        deallocate cursor1
        commit tran 
end try 
   begin catch  
          rollback tran 
          close cursor1  
          deallocate cursor1 
   end catch  

go

/* ----------  ASIGNAR MATERIA MAESTRO ---------------*/

create procedure sp_AsignarMateria @ci varchar(10),@idmateria int,@idgest int,@idcurso int,@idnivel int as
 begin try 
   begin tran   
   
   insert into maestromater values (@ci,@idmateria,GETDATE(),'Asignado',@idgest,@idcurso,@idnivel,'0')

   declare cursor1 cursor for select idmateria from materia where idcurso=@idcurso and idnivel=@idnivel
   declare @idmat int

   open cursor1
   fetch cursor1 into @idmat

   while (@@fetch_status=0) 
     begin
        update materia set descripcion = descripcion + ' - Asignada' where idmateria = @idmat
       fetch cursor1 into @idmat
    end
  close cursor1
  deallocate cursor1
  commit tran 
end try 
   begin catch  
         rollback tran 
         close cursor1  
         deallocate cursor1 
   end catch  
 
go

create procedure sp_QuitarMateria @ci varchar(10),@idmateria int as
 
 begin try 
   begin tran    

         delete from maestromater where ci=@ci and idmateria=@idmateria 

         declare cursor1 cursor for select idmateria from materia where idmateria=@idmateria
         declare @idmat int

         open cursor1
         fetch cursor1 into @idmat

         while (@@fetch_status=0) 
           begin
              update materia set descripcion = REPLACE(descripcion,' - Asignada','') where idmateria = @idmat
             fetch cursor1 into @idmat
          end
        close cursor1
        deallocate cursor1
        commit tran 
end try 
   begin catch  
          rollback tran 
          close cursor1  
          deallocate cursor1 
   end catch  

go