<?xml version="1.0" encoding="UTF-8"?> 
    <cfdi:Comprobante version="3.2" serie="SERIE" folio="'.$folioID.'" fecha="'.date('j-m-y').' '.date('H:i:s').'"  
            formaDePago="FormaPago" noCertificado="00001000000201703011" 
            certificado="MIIEaTCCA1GgAwIBAgIUMDAwMDEwMDAwMDAzMDMyODAwMDkwDQYJKoZIhvcNAQEFBQAwggGKMTgwNgYDVQQDDC9BLkMuIGRlbCBTZXJ2aWNpbyBkZSBBZG1pbmlzdHJhY2nDs24gVHJpYnV0YXJpYTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMR8wHQYJKoZIhvcNAQkBFhBhY29kc0BzYXQuZ29iLm14MSYwJAYDVQQJDB1Bdi4gSGlkYWxnbyA3NywgQ29sLiBHdWVycmVybzEOMAwGA1UEEQwFMDYzMDAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBEaXN0cml0byBGZWRlcmFsMRQwEgYDVQQHDAtDdWF1aHTDqW1vYzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMTUwMwYJKoZIhvcNAQkCDCZSZXNwb25zYWJsZTogQ2xhdWRpYSBDb3ZhcnJ1YmlhcyBPY2hvYTAeFw0xNDAzMTExODU1MjJaFw0xODAzMTExODU1MjJaMIG1MR0wGwYDVQQDExQzRUdBU1YgUyBERSBSTCBERSBDVjEdMBsGA1UEKRMUM0VHQVNWIFMgREUgUkwgREUgQ1YxHTAbBgNVBAoTFDNFR0FTViBTIERFIFJMIERFIENWMSUwIwYDVQQtExxFR0ExMDA5MDJNMTMgLyBNQUFFNzgwNTEzQjE0MR4wHAYDVQQFExUgLyBNQUFFNzgwNTEzSE1OR0xEMDkxDzANBgNVBAsTBlVOSURBRDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3H41Z+wNaZJQRxhgoWBsYed8JFRL69sTcYg852j3db7k6AcsSu+MzygurtHJK0drrqgZ4k6hm4hkKK0vRUckwXCvUWNsGUtlGe79Y1wN2025FXE+OOOeU9DhBynS8m7JJTbIXcMfWGJ0G/7TJXIJEJcV/kzmDYNElgd0Z8BxeQsCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBANMWDXgtg1G+XAhWz+Xu5GWJ1PleFz3MlSW+rksRbYznXD1KVJfAUJDg1Z6nRB0R++IGIjiWt4dXwJx1GE8zLWpCxJyYY54BBTNJjgnynNYIbbtyCwVNi1FZyNQg8ocFizMJCFYm9/QYgSJ5zYx4yJME8WGvAgwAOTvDCslPDnctPYjztqQwbvdnIefypolsbH9fd4Xr7f2Fvy0vgdytJIIU7Le+6eb5UE1Mp9jp2G+PKftv6MqntN8kFBu4Ps2yEexiXwlcdGaCqHhFsL9ESkYqP4N53rAr7xS154hzjVqjDEJMefo+A5u/AiFPSRaYciGrUCDOpPHMFsMeURmUqpg=" 
            condicionesDePago="CondicionesDePago" subTotal="'.$precioPorUnidad.'" TipoCambio="1.0" Moneda="Pesos" 
            total="'.$precioPorUnidad.'" tipoDeComprobante="ingreso" 
            metodoDePago="metodopago"LugarExpedicion="lugarExpedicion" 
            NumCtaPago="numctapago" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/leyendasFiscales http://www.sat.gob.mx/sitio_internet/cfd/leyendasFiscales/leyendasFisc.xsd" 
            xmlns:leyendasFisc="http://www.sat.gob.mx/leyendasFiscales" xmlns:cfdi="http://www.sat.gob.mx/cfd/3"xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
            
            <cfdi:Emisor rfc="EGA100902M13" nombre="3EGASV S DE RL DE CV"> 
                <cfdi:DomicilioFiscal calle="Periférico Paseo de la República" codigoPostal="58147" estado="Michoacán" municipio="Morelia" pais="México" colonia="14 de febrero" noExterior="7875" noInterior=""/>
                    <cfdi:RegimenFiscal Regimen="Régimen General de ley personas morales"/> 
            </cfdi:Emisor> 

            <cfdi:Receptor nombre="'.$razonSocial.'" rfc="'.$rfc.'"> 
                <cfdi:Domicilio calle="'.$calle.'" codigoPostal="'.$cp.'" colonia="'.$colonia.'" estado="'.$estado.'" municipio="'.$municipio.'" noExterior="'.$numExterior.'" noInterior="'.$numInterior.'" pais="'.$pais.'"/> 
            </cfdi:Receptor> 
            <cfdi:Conceptos> 
                <cfdi:Concepto unidad="'.$concepto.'" descripcion="'.$vehiculo.'" importe="'.$precioPorUnidad.'" valorUnitario="'.$precioPorUnidad.'" importe="'.$total.'" noIdentificacion="'.$idventasFactura.'" /> 
            </cfdi:Conceptos> 
            <cfdi:Impuestos> 
                <cfdi:Traslados> 
                    <cfdi:Traslado tasa="tasa" importe="importe" impuesto="IVA"/> 
                </cfdi:Traslados> </cfdi:Impuestos> 
                <cfdi:Complemento>   
                </cfdi:Complemento> 
    </cfdi:Comprobante>', 

