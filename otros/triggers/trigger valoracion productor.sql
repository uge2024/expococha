DROP TRIGGER IF EXISTS trigger_actualizar_puntuacion_productor ON vpr_valoracion_productor;

CREATE OR REPLACE FUNCTION fun_actualizar_puntuacion_productor()
  RETURNS TRIGGER AS 
$$
DECLARE
	varproid bigint := 0;
	sumatotalpuntuacion integer := 0;
	cantidadvaloraciones integer := 0;
	puntuacionproductor integer := 1;
	valoraciontemp RECORD;
BEGIN
	
	IF(TG_OP = 'INSERT') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varproid := NEW.pro_id;
	END IF;
	IF(TG_OP = 'UPDATE') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varproid := NEW.pro_id;
	END IF;
	IF(TG_OP = 'DELETE') THEN
		--RAISE INFO 'la operacion es : %',TG_OP;
		varproid := OLD.pro_id;
	END IF;
	
	FOR valoraciontemp IN
        SELECT * FROM vpr_valoracion_productor WHERE estado = 'AC' AND pro_id = varproid  
    LOOP
		
		--RAISE INFO 'vpr_id: % productor id: % tiene un puntaje: %',valoraciontemp.vpr_id,valoraciontemp.pro_id,valoraciontemp.puntuacion;
		
		sumatotalpuntuacion := sumatotalpuntuacion + valoraciontemp.puntuacion;
		cantidadvaloraciones := cantidadvaloraciones + 1;
		
    END LOOP;
	--RAISE INFO 'suma total puntuacion: % y cantidad total de valoraciones: %',sumatotalpuntuacion,cantidadvaloraciones;
	
	IF(cantidadvaloraciones <> 0)THEN 
		puntuacionproductor := CEILING(sumatotalpuntuacion / cantidadvaloraciones);
	END IF;
	
	--RAISE INFO 'el puntaje promedio es: %',puntuacionproductor;
	UPDATE pro_productor 
		SET puntuacion = puntuacionproductor
		WHERE pro_id = varproid;
	
	RETURN NEW;
	
	
	EXCEPTION
    WHEN data_exception THEN
        RAISE WARNING '[public.fun_actualizar_puntuacion_productor] - UDF ERROR [DATA EXCEPTION] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NEW;
    WHEN OTHERS THEN
        RAISE WARNING '[public.fun_actualizar_puntuacion_productor] - UDF ERROR [OTHER] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NEW;

END;
$$
LANGUAGE 'plpgsql';


CREATE TRIGGER trigger_actualizar_puntuacion_productor 
  AFTER INSERT OR UPDATE OR DELETE 
  ON vpr_valoracion_productor 
  FOR EACH ROW
  EXECUTE PROCEDURE fun_actualizar_puntuacion_productor();