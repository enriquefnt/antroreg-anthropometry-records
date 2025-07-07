CREATE DEFINER=`saltaped_enrique`@`%` FUNCTION `ZSCORE`(sexo INT(1),bus VARCHAR(1), valor DOUBLE,fecha_nace DATE,fecha_control DATE) RETURNS double
BEGIN
DECLARE calculo_z,L,M,S DOUBLE;
DECLARE edad_mes,edad_dias INT;
     
          
            SET edad_mes=TIMESTAMPDIFF(MONTH,fecha_nace,fecha_control);
		SET edad_dias=TIMESTAMPDIFF(DAY,fecha_nace,fecha_control);
        case 
        
        when (edad_dias < 1875 and sexo=2 and bus = 'p') then
        SET L=(SELECT la FROM tablaPEx WHERE age=edad_dias);
        SET M=(SELECT ma FROM tablaPEx WHERE age=edad_dias);
        SET S=(SELECT sa FROM tablaPEx WHERE age=edad_dias);
        when (edad_dias < 1875 and sexo=2 and bus = 't') then
        SET L=(SELECT la FROM tablaTEx WHERE age=edad_dias);
        SET M=(SELECT ma FROM tablaTEx WHERE age=edad_dias);
        SET S=(SELECT sa FROM tablaTEx WHERE age=edad_dias);
        when (edad_dias < 1875 and sexo=2 and bus = 'i') then
        SET L=(SELECT la FROM tablaIMCx WHERE age=edad_dias);
        SET M=(SELECT ma FROM tablaIMCx WHERE age=edad_dias);
        SET S=(SELECT sa FROM tablaIMCx WHERE age=edad_dias);
        
        when (edad_dias < 1875 and sexo=1 and bus = 'p') then
        SET L=(SELECT lo FROM tablaPEx WHERE age=edad_dias);
        SET M=(SELECT mo FROM tablaPEx WHERE age=edad_dias);
        SET S=(SELECT so FROM tablaPEx WHERE age=edad_dias);
        when (edad_dias < 1875 and sexo=1 and bus = 't') then
        SET L=(SELECT lo FROM tablaTEx WHERE age=edad_dias);
        SET M=(SELECT mo FROM tablaTEx WHERE age=edad_dias);
        SET S=(SELECT so FROM tablaTEx WHERE age=edad_dias);
        when (edad_dias < 1875 and sexo=1 and bus = 'i') then
        SET L=(SELECT lo FROM tablaIMCx WHERE age=edad_dias);
        SET M=(SELECT mo FROM tablaIMCx WHERE age=edad_dias);
        SET S=(SELECT so FROM tablaIMCx WHERE age=edad_dias);
        
        
        when (edad_mes > 59 and sexo=2 and bus = 'p') then
        SET L=(SELECT la FROM tablaPE6x WHERE age_s =edad_mes);
        SET M=(SELECT ma FROM tablaPE6x WHERE age_s =edad_mes);
        SET S=(SELECT sa FROM tablaPE6x WHERE age_s =edad_mes);
        when (edad_mes > 59 and sexo=2 and bus = 't') then
        SET L=(SELECT la FROM tablaTE6x WHERE age_s =edad_mes);
        SET M=(SELECT ma FROM tablaTE6x WHERE age_s =edad_mes);
        SET S=(SELECT sa FROM tablaTE6x WHERE age_s =edad_mes);
        when (edad_mes > 59 and sexo=2 and bus = 'i') then
        SET L=(SELECT la FROM tablaIMCE6x WHERE age_s =edad_mes);
        SET M=(SELECT ma FROM tablaIMCE6x WHERE age_s =edad_mes);
        SET S=(SELECT sa FROM tablaIMCE6x WHERE age_s =edad_mes);
        
        when (edad_mes > 59 and sexo=1 and bus = 'p') then
        SET L=(SELECT lo FROM tablaPE6x WHERE age_s=edad_mes);
        SET M=(SELECT mo FROM tablaPE6x WHERE age_s=edad_mes);
        SET S=(SELECT so FROM tablaPE6x WHERE age_s=edad_mes);
        when (edad_mes > 59 and sexo=1 and bus = 't') then
        SET L=(SELECT lo FROM tablaTE6x WHERE age_s=edad_mes);
        SET M=(SELECT mo FROM tablaTE6x WHERE age_s=edad_mes);
        SET S=(SELECT so FROM tablaTE6x WHERE age_s=edad_mes);
        when (edad_mes > 59 and sexo=1 and bus = 'i') then
        SET L=(SELECT lo FROM tablaIMCE6x WHERE age_s=edad_mes);
        SET M=(SELECT mo FROM tablaIMCE6x WHERE age_s=edad_mes);
        SET S=(SELECT so FROM tablaIMCE6x WHERE age_s=edad_mes);
    
     END CASE;
    
     SET calculo_z =(POWER((valor/M),L)-1)/(L*S);

     RETURN calculo_z ;
END