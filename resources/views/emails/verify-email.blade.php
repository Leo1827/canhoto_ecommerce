<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifique seu e-mail</title>
</head>
<body style="margin: 0; padding: 0; background-color: #edf2f7; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 25px 0;">
                <a href="https://canhotopremium.com" target="_blank">
                    <img src="https://garrafeiracanhoto.com/cdn/shop/files/IMG_0015.jpg?v=1737752552&width=160" alt="Canhoto Premium" style="height:75px;width:75px;border:none;">
                </a>
            </td>
        </tr>

        <tr>
            <td width="100%" style="background-color: #edf2f7; padding: 0;">
                <table align="center" width="570" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:2px; border:1px solid #e8e5ef;">
                    <tr>
                        <td style="padding: 32px; max-width: 100vw;">
                            <h1 style="font-size: 18px; font-weight: bold; color: #3d4852; margin-top: 0; text-align: left;">Olá!</h1>
                            <p style="font-size: 16px; line-height: 1.5em; text-align: left;">
                                Obrigado por se registrar. Por favor, clique no botão abaixo para verificar seu endereço de e-mail.
                            </p>

                            <table align="center" width="100%" cellpadding="0" cellspacing="0" style="margin: 30px auto; text-align: center;">
                                <tr>
                                    <td align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <a href="{{ $url }}" target="_blank" rel="noopener"
                                                        style="border-radius:4px;background-color:#2d3748;color:#ffffff;display:inline-block;text-decoration:none;
                                                        border:8px solid #2d3748;border-left-width:18px;border-right-width:18px;font-size:16px;font-weight:bold;">
                                                        Verificar e-mail
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; line-height: 1.5em; text-align: left;">
                                Se você não criou esta conta, nenhuma ação é necessária.
                            </p>

                            <p style="font-size: 16px; line-height: 1.5em; text-align: left;">
                                Atenciosamente,<br>Equipe Canhoto Premium
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e8e5ef; margin-top:25px; padding-top:25px;">
                                <tr>
                                    <td>
                                        <p style="font-size: 14px; line-height: 1.5em; text-align: left;">
                                            Se você estiver com problemas para clicar no botão "Verificar e-mail", copie e cole o link abaixo no seu navegador:
                                            <br><a href="{{ $url }}" style="color:#3869d4;word-break:break-all;" target="_blank">{{ $url }}</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table align="center" width="570" cellpadding="0" cellspacing="0" style="text-align: center; margin: 0 auto;">
                    <tr>
                        <td style="padding: 32px; color: #b0adc5; font-size: 12px;">
                            © {{ date('Y') }} Canhoto Premium. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
