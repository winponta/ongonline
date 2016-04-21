package br.com.ongonline.fingerkey;

import com.nitgen.SDK.BSP.NBioBSPJNI;

/**
 *
 * @author Ademir Mazer Jr <ademir.mazer.jr@gmail.com>
 */
public class Nitgen {

    private String[] errors = {
        "Nenhum erro", // 0
        "Invalid handle", // 1
    };

    private NBioBSPJNI.IndexSearch objIndex;
    private String mensagemStatus;
    private String digital;
    private boolean operacaoExecutada;
    private int digitalCapturadaStatusDispositivo;
    private int UserID;

    private static String DEBUG_PREFIX = "WINPONTA NITGEN - DEBUG :: ";

    private NBioBSPJNI bsp;
    private NBioBSPJNI.DEVICE_ENUM_INFO deviceEnumInfo;
    private NBioBSPJNI.IndexSearch IndexSearchEngine;

    private boolean hasError = false;
    private boolean hardwareInicializado = false;
    private boolean dispositivoAberto = false;

    public Nitgen() {
        this.deviceEnumInfo = null;
        this.objIndex = null;
        this.operacaoExecutada = false;
        this.mensagemStatus = "";
        this.digitalCapturadaStatusDispositivo = 0;
        this.UserID = 0;
        this.digital = "";

        this.bsp = new NBioBSPJNI();
        if (checkError()) {
            System.out.println(Nitgen.DEBUG_PREFIX + "Erro ao criar objeto NBioBSPJNI");
            return;
        }

        this.deviceEnumInfo = this.bsp.new DEVICE_ENUM_INFO();
        this.bsp.EnumerateDevice(this.deviceEnumInfo);

        if (checkError()) {
            System.out.println(Nitgen.DEBUG_PREFIX + "Erro ao enumerar device");
            return;
        }

        int n = this.deviceEnumInfo.DeviceCount;

        if (n == 0) {
            System.out.println(Nitgen.DEBUG_PREFIX + "Componente não iniciado");
            return;
        } else {
            System.out.println(Nitgen.DEBUG_PREFIX + "Dispositivo Liberado");
        }

        this.hardwareInicializado = true;
        System.out.println(Nitgen.DEBUG_PREFIX + "Dispositivo Iniciado com Sucesso");
    }

    public boolean openDevice() {
        if (this.hardwareInicializado) {
            this.bsp.OpenDevice(this.deviceEnumInfo.DeviceInfo[0].NameID, this.deviceEnumInfo.DeviceInfo[0].Instance);
            this.dispositivoAberto = true;
            System.out.println(Nitgen.DEBUG_PREFIX + "Dispositivo Liberado");
            return true;
        } else {
            System.out.println(Nitgen.DEBUG_PREFIX + "Dispositivo Desconectado");
            return false;
        }
    }

    public short getDeviceNameID() {
        if (this.hardwareInicializado) {
            return this.deviceEnumInfo.DeviceInfo[0].NameID;
        } else {
            return 0;
        }
    }

    public void closeDevice() {
        this.bsp.CloseDevice(this.deviceEnumInfo.DeviceInfo[0].NameID, this.deviceEnumInfo.DeviceInfo[0].Instance);
        this.dispositivoAberto = false;
    }

    public String getDeviceName() {
        if (this.hardwareInicializado) {
            return this.deviceEnumInfo.DeviceInfo[0].Name;
        } else {
            return "Dispositivo não está aberto";
        }
    }

    public boolean enrollStringKey() {
        //Inicialização e instanciações
        this.mensagemStatus = "";
        this.operacaoExecutada = false;
        this.digital = null;

        if (!this.hardwareInicializado || !this.dispositivoAberto) {
            this.mensagemStatus = "Dispositivo não foi inicializado ou não está conectado";
        }
        
        NBioBSPJNI.FIR_HANDLE fir_handle = this.bsp.new FIR_HANDLE();
        this.objIndex = this.bsp.new IndexSearch();
        NBioBSPJNI.FIR_TEXTENCODE textSavedFIR = null;
        Boolean fingerPlaced = new Boolean(false);
        this.bsp.CheckFinger(fingerPlaced);

        if (fingerPlaced) {
            //Captura a digital
            this.bsp.Capture(fir_handle);

            //Obtem a digital capturada em modo texto
            if (!this.bsp.IsErrorOccured()) {
                textSavedFIR = this.bsp.new FIR_TEXTENCODE();
                this.digitalCapturadaStatusDispositivo = this.bsp.GetTextFIRFromHandle(fir_handle, textSavedFIR);
                this.digital = textSavedFIR.TextFIR;
                this.operacaoExecutada = true;

//                NBioBSPJNI.INPUT_FIR inputFIR = this.bsp.new INPUT_FIR();
//                inputFIR.SetFIRHandle(fir_handle);
//                NBioBSPJNI.IndexSearch.FP_INFO fpInfo = objIndex.new FP_INFO();
//                objIndex.Identify(inputFIR, 6, fpInfo, 5000);
//
//                if (fpInfo.ID > 0) {
//                    setUserID(fpInfo.ID);
//                    this.setMensagemStatus("Cliente encontrado!");
//                } else {
//                    setUserID(0);
//                    this.setMensagemStatus("Nenhum cliente encontrado!");
//                }
            } else {
                this.operacaoExecutada = false;
                System.out.println("Erro na captura e/ou dispositivo");
                this.digital = null;
                //setUserID(0);
            }
        } else {
            // setUserID(0);
            if (this.hardwareInicializado) {
                this.mensagemStatus = "Não foi detectada presença de digitais no dispositivo";
                System.out.println("Nenhum dedo no dispositivo");
            } else {
                this.mensagemStatus = "Dispositivo não foi inicializado ou não está conectado";
                System.out.println("Dispositivo Desconectado");
            }
        }

        return this.operacaoExecutada;
    }

    public String getFingerkey() {
        return this.digital;
    }
    
    public boolean checkError() {
        this.hasError = bsp.IsErrorOccured();

        if (this.hasError) {
            System.err.println(Nitgen.DEBUG_PREFIX + this.getLastErrorMessage());
        }

        return this.hasError;
    }

    public int getLastErrorCode() {
        if (this.hasError) {
            return this.bsp.GetErrorCode();
        } else {
            return 0;
        }
    }

    public String getLastErrorMessage() {
        return this.errors[this.bsp.GetErrorCode()];
    }

    public String getVersion() {
        return this.bsp.GetVersion();
    }
    
    public String getStatusMessage() {
        return this.mensagemStatus;
    }
}
