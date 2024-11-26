DROP TRIGGER IF EXISTS trigger_actualizar_puntuacion_producto ON vpd_valoracion_producto;

CREATE OR REPLACE FUNCTION fun_actualizar_puntuacion_producto()
  RETURNS TRIGGER AS 
$$
DECLARE
	varprdid bigint := 0;
	sumatotalpuntuacion integer := 0;
	cantidadvaloraciones integer := 0;
	puntuacionproducto integer := 1;
	valoraciontemp RECORD;
BEGIN
	
	IF(TG_OP = 'INSERT') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varprdid := NEW.prd_id;
	END IF;
	IF(TG_OP = 'UPDATE') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varprdid := NEW.prd_id;
	END IF;
	IF(TG_OP = 'DELETE') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varprdid := OLD.prd_id;
	END IF;
	
	FOR valoraciontemp IN
        SELECT * FROM vpd_valoracion_producto WHERE estado = 'AC' AND prd_id = varprdid  
    LOOP
		
		--RAISE INFO 'vpd_id: % producto id: % tiene un puntaje: %',valoraciontemp.vpd_id,valoraciontemp.prd_id,valoraciontemp.puntuacion;
		
		sumatotalpuntuacion := sumatotalpuntuacion + valoraciontemp.puntuacion;
		cantidadvaloraciones := cantidadvaloraciones + 1;
		
    END LOOP;
	--RAISE INFO 'suma total puntuacion: % y cantidad total de valoraciones: %',sumatotalpuntuacion,cantidadvaloraciones;
	
	IF(cantidadvaloraciones <> 0)THEN 
		puntuacionproducto := CEILING(sumatotalpuntuacion / cantidadvaloraciones);
	END IF;
	
	--RAISE INFO 'el puntaje promedio es: %',puntuacionproducto;
	UPDATE prd_producto 
		SET puntuacion = puntuacionproducto
		WHERE prd_id = varprdid;
	
	RETURN NEW;
	
	
	EXCEPTION
    WHEN data_exception THEN
        RAISE WARNING '[public.fun_actualizar_puntuacion_producto] - UDF ERROR [DATA EXCEPTION] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NEW;
    WHEN OTHERS THEN
        RAISE WARNING '[public.fun_actualizar_puntuacion_producto] - UDF ERROR [OTHER] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NEW;

END;
$$
LANGUAGE 'plpgsql';


CREATE TRIGGER trigger_actualizar_puntuacion_producto 
  AFTER INSERT OR UPDATE OR DELETE 
  ON vpd_valoracion_producto 
  FOR EACH ROW
  EXECUTE PROCEDURE fun_actualizar_puntuacion_producto();