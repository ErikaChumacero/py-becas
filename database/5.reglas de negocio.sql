/* ----- CAMBIAR CONTRASEÑA USUARIO -----------------*/

   create procedure sp_cambiarclaveusuario @ci varchar(10),@claveant varchar(100),@clavenue varchar(100) as
      update persona set contrasena = @clavenue where ci = @ci and contrasena=@claveant 
   go 


/* ----------  CERRAR UNA GESTION ESCOLAR ---------------*/

create procedure sp_CerrarGestion @idgest int as
      update gestion set fechacierre = GETDATE(), estado = '0'  where idgestion = @idgest
go

CREATE OR ALTER PROCEDURE sp_AbrirGestion @idgest int AS
    UPDATE gestion SET estado = '1' WHERE idgestion = @idgest
GO

/* ----------  ASIGNAR BECA ESTUDIANTE CAMBIOS SI HAY ERROR REVISAR---------------*/

CREATE OR ALTER PROCEDURE sp_AsignarBeca 
    @ci varchar(10),
    @codbeca int,
    @idgest int 
AS
BEGIN
    SET NOCOUNT ON;
    
    BEGIN TRY
        BEGIN TRAN
            UPDATE inscripcion 
            SET codbeca = @codbeca 
            WHERE ci = @ci AND idgestion = @idgest;
            
            UPDATE m
            SET observacion = 'Beca Aplicada'
            FROM mensualidad m
            INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
            WHERE m.ci = @ci AND i.idgestion = @idgest;
        COMMIT TRAN
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRAN;
        THROW;
    END CATCH
END
GO
/* ----------------  CALCULAR MONTO TOTAL MENSUALIDAD ---------------*/

CREATE PROCEDURE sp_CalcularMontoTotal @iddetalle INT AS

   declare @total smallmoney 
   declare @monto smallmoney
   declare @descuento int

    SELECT @monto = monto, @descuento = descuento FROM detallemensualidad WHERE iddetallemensualidad =@iddetalle;
    
    SET @total = @monto - (@monto * @descuento / 100);
    
    update detallemensualidad set montototal = @total where iddetallemensualidad =@iddetalle 

GO
--Cambios REVISAR ACA SI AHI ERROR--
CREATE OR ALTER PROCEDURE sp_QuitarBeca 
    @ci varchar(10),
    @idgest int 
AS
BEGIN
    SET NOCOUNT ON;
    
    BEGIN TRY
        BEGIN TRAN
            UPDATE inscripcion 
            SET codbeca = NULL 
            WHERE ci = @ci AND idgestion = @idgest;
            
            UPDATE m
            SET observacion = 'Beca Quitada'
            FROM mensualidad m
            INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
            WHERE m.ci = @ci AND i.idgestion = @idgest;
        COMMIT TRAN
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRAN;
        THROW;
    END CATCH
END
GO

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
--Cambios REVISAR ACA SI AHI ERROR la la --
CREATE OR ALTER PROCEDURE sp_QuitarMateria 
    @ci varchar(10),
    @idmateria int 
AS
BEGIN
    SET NOCOUNT ON;
    
    BEGIN TRY
        BEGIN TRAN
            DELETE FROM maestromater 
            WHERE ci = @ci AND idmateria = @idmateria;
        COMMIT TRAN
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRAN;
        THROW;
    END CATCH
END
GO
--Nuevas reglas de negocio Revisar si hay error--
/* ----------  VALIDAR INSCRIPCION UNICA POR GESTION ---------------*/
CREATE OR ALTER PROCEDURE sp_ValidarInscripcionUnica 
    @ci varchar(10), 
    @idgestion int 
AS
BEGIN
    SET NOCOUNT ON;
    
    IF EXISTS (SELECT 1 FROM inscripcion WHERE ci = @ci AND idgestion = @idgestion)
    BEGIN
        RAISERROR('El estudiante ya tiene una inscripción en esta gestión', 16, 1);
        RETURN 1;
    END
    
    RETURN 0;
END
GO
--nuevas reglas de negocio Revisar si hay error--
CREATE OR ALTER PROCEDURE sp_CerrarGestionesVencidas 
AS
BEGIN
    SET NOCOUNT ON;
    
    UPDATE gestion 
    SET estado = '0', fechacierre = GETDATE()
    WHERE estado = '1' AND fechacierre < GETDATE();
    
    SELECT @@ROWCOUNT as GestionesCerradas;
END
GO